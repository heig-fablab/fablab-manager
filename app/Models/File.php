<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Constants\EventTypes;
use RarArchive;
use ZipArchive;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hash',
        'directory',
        'file_type_id',
        'job_id',
        'job_category_id',
    ];

    // Belongs to
    public function job_category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class);
    }

    public function file_type(): BelongsTo
    {
        return $this->belongsTo(FileType::class);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    // File Storage Service
    public const PRIVATE_FILE_STORAGE_PATH = 'private/file-storage/';
    public const PUBLIC_FILE_STORAGE_PATH = 'public/';
    public const HASH_ALGORITHM = 'sha256';
    public const MAX_FILE_SIZE = 10_000_000; // Size is in bytes 10'000'000 B = 10 Mo

    // File Type not corrected detected by function ->extension() given by Laravel
    public const FILE_TYPES_NOT_DETECTED_WITH_CORRESPONDENCE = [
        'ai', // pdf detected
        'dxf', // txt detected
        'iges', // txt detected
        'stl', // bin detected
        'md', // txt detected
    ];

    public const FILE_TYPES_NOT_DETECTED_WITHOUT_CORRESPONDENCE = [
        // These are not tested but are here in prevention
        'step',
        'Sldprt',
        'gbr',
        'PcbDoc',
        'PrjPcb',
        'SchDoc',
    ];

    private static function get_file_type_correspondence(string $file_type): string {
        return match ($file_type) {
            'ai' => 'pdf',
            'dxf', 'iges', 'md' => 'txt',
            'stl' => 'bin',
            default => $file_type,
        };
    }

    private static function create_event_and_mail(int $job_id, File $file)
    {
        // Create and save Event (notify worker)
        $user_to_notify_switch_uuid = Job::findOrFail($job_id)->worker_switch_uuid;

        if ($user_to_notify_switch_uuid != null) {
            Event::create([
                'type' => EventTypes::FILE,
                'to_notify' => true,
                'user_switch_uuid' => $user_to_notify_switch_uuid,
                'job_id' => $job_id,
                'data' => $file->name,
            ]);

            // Emails
            Event::create_mail_job($user_to_notify_switch_uuid);
        }
    }

    private static function is_file_type_not_detected_with_correspondence(string $file_type): bool
    {
        return in_array($file_type, self::FILE_TYPES_NOT_DETECTED_WITH_CORRESPONDENCE);
    }

    private static function is_file_type_not_detected_without_correspondence(string $file_type): bool
    {
        return in_array($file_type, self::FILE_TYPES_NOT_DETECTED_WITHOUT_CORRESPONDENCE);
    }

    private static function is_file_type_not_detected(string $file_type): bool
    {
        return self::is_file_type_not_detected_with_correspondence($file_type)
            || self::is_file_type_not_detected_without_correspondence($file_type);
    }


    public static function is_valid_file($file, $accepted_file_types): bool
    {
        if ($file == null) {
            Log::Info("File is null");
            return false;
        }

        if ($file->getSize() > File::MAX_FILE_SIZE) {
            Log::Info("File is too big");
            return false;
        }

        log::Debug("mime type extension detected: " . $file->extension());
        log::Debug("original extension detected: " . $file->getClientOriginalExtension());

        // Verify file type matching with file type detected from content
        // Some types are detected false and we know them, a correspondence function is used
        // Some other, we don't know yet the correspondence and go further
        $file_type_matching_ok = true;
        if (self::is_file_type_not_detected_with_correspondence($file->getClientOriginalExtension())) {
            $file_type_correspondence = self::get_file_type_correspondence($file->getClientOriginalExtension());
            $file_type_matching_ok = $file_type_correspondence == $file->extension();
        } else if (!self::is_file_type_not_detected_without_correspondence($file->getClientOriginalExtension())
            && $file->getClientOriginalExtension() != $file->extension()) {
            $file_type_matching_ok = false;
        }

        if (!$file_type_matching_ok) {
            log::Info("Original extension and extension detected by mime type mismatch");
            return false;
        }

        // Verify if file type exists in BD
        $file_type = FileType::where('name', '=', $file->getClientOriginalExtension())->first();
        if ($file_type == null) {
            log::Info("File type not found in BD");
            return false;
        }

        // $file->extension() = Determine the file's extension based on the file's MIME type
        // Check matching file type with file extension
        if (!self::is_file_type_not_detected($file->getClientOriginalExtension())
            && $file_type->name != $file->extension()) {
            log::Info("File type mismatch");
            return false;
        }

        // Verify if in accepted types
        if (!in_array($file->getClientOriginalExtension(), $accepted_file_types)) {
            log::Info("File type not accepted for this job category");
            return false;
        }

        return true;
    }

    public static function download_file($file)
    {
        if ($file != null) {
            return Storage::download(File::PRIVATE_FILE_STORAGE_PATH . $file->directory . '/' . $file->hash, $file->name);
        } else {
            return null;
        }
    }

    public static function get_file_url($file)
    {
        if ($file != null) {
            return asset(Storage::url(File::PUBLIC_FILE_STORAGE_PATH . $file->directory . '/' . $file->hash));
        } else {
            return null;
        }
    }

    public static function store_file($req_file, $job_id, bool $is_public = false): File
    {
        // File infos
        $hash = hash_file(File::HASH_ALGORITHM, $req_file);
        $dir = substr($hash, 0, 2);
        $file_type = FileType::where('name', '=', $req_file->getClientOriginalExtension())->firstOrFail();

        // Create file for DB
        $file = File::create([
            'name' => $req_file->getClientOriginalName(),
            'hash' => $hash,
            'directory' => $dir,
            'file_type_id' => $file_type->id,
            'job_id' => $job_id,
        ]);

        if ($job_id != null) {
            File::create_event_and_mail($job_id, $file);
        }

        // Add to filestorage
        // Create a directory with 2 first letter of hashed_name
        // It's a Laravel trick to not be stopped after x files in directory
        $file_storage_path = $is_public ? File::PUBLIC_FILE_STORAGE_PATH : File::PRIVATE_FILE_STORAGE_PATH;
        $req_file->storeAs($file_storage_path . $dir, $hash);

        return $file;
    }

    public static function update_file(File $file, $req_file, bool $is_public = false): File
    {
        $hash = hash_file(File::HASH_ALGORITHM, $req_file);
        $dir = substr($hash, 0, 2);
        $file_storage_path = $is_public ? File::PUBLIC_FILE_STORAGE_PATH : File::PRIVATE_FILE_STORAGE_PATH;

        if ($hash != $file->hash || $dir != $file->directory) {
            // Delete old file
            File::delete_file($file, true);

            // Create new file
            $req_file->storeAs($file_storage_path . $dir, $hash);

            // Update file infos linked to physic file content for BD
            $file_type = FileType::where('name', '=', $req_file->getClientOriginalExtension())->firstOrFail();
            $file->hash = $hash;
            $file->directory = $dir;
            $file->file_type_id = $file_type->id;

            if ($file->job->id != null) {
                File::create_event_and_mail($file->job->id , $file);
            }
        }

        // Update file infos for BD
        $file->name = $req_file->getClientOriginalName();
        $file->save();

        return $file;
    }

    public static function delete_file(File $file, bool $is_public = false)
    {
        $file_storage_path = $is_public ? File::PUBLIC_FILE_STORAGE_PATH : File::PRIVATE_FILE_STORAGE_PATH;

        Storage::delete($file_storage_path . $file->directory . '/' . $file->hash);

        // Delete only empty folder
        if (Storage::exists($file_storage_path. $file->directory)) {
            Storage::deleteDirectory($file_storage_path . $file->directory);
        }
    }
}
