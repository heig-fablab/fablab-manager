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
    public const FILE_TYPES_NOT_DETECTED = [
        'ai',
        'dxf',
    ];

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

    private static function is_file_type_detected(string $file_type) {
        return !in_array($file_type, self::FILE_TYPES_NOT_DETECTED);
    }

    // TODO: try to validate files in rar
    private static function validate_rar_files($file): bool {
        // open the archive file
        $archive = RarArchive::open($file);
        // make sure it's valid
        if ($archive === false) return false;

        // retrieve a list of entries in the archive
        $entries = $archive->getEntries();
        // make sure the entry list is valid
        if ($entries === false) return false;

        // loop over entries
        foreach ($entries as $e) {
            Log::Debug($e);
        }
        // close the archive file
        $archive->close();

        return true;
    }

    // TODO: try to validate files in zip
    private static function validate_zip_files($file): bool {
        // open the archive file
        $archive = new ZipArchive;
        $valid = $archive->open($file);
        // make sure it's valid (if not ZipArchive::open() returns various error codes)
        if ($valid !== true) return false;

        // make sure the entry list is valid
        if ($archive->numFiles === 0) return false;
        // example output of entry count

        // loop over entries
        for ($i = 0; $i < $archive->numFiles; $i++) {
            $e = $archive->statIndex($i);
            Log::Debug( $e['name']);
        }
        // close the archive file (redundant as called automatically at the end of the script)
        $archive->close();

        return true;
    }

    // TODO: Validate file type with mime type
    // We can't validate some file type because they don't have one known.
    // https://www.php.net/manual/fr/function.mime-content-type.php
    // Doesn't work cause we need to give a path and not directly the file
    private static function is_valid_file_mime_type($file, string $mime_type_waited): bool {
        log::Debug("File mime type detected: " . mime_content_type($file->getClientOriginalName()));

        if ($mime_type_waited == null) {
            return true;
        } else {
            return mime_content_type($file->getClientOriginalName()) == $mime_type_waited;
        }
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

        // TODO: try to validate files in rar and zip
        /*if ($file->getClientOriginalExtension() == 'rar') {
            if (!self::validate_rar_files($file)) {
                log::Info("Invalid files in rar");
                return false;
            }
        }

        if ($file->getClientOriginalExtension() == 'zip') {
            if (!self::validate_zip_files($file)) {
                log::Info("Invalid files in zip");
                return false;
            }
        }*/

        if (self::is_file_type_detected($file->getClientOriginalExtension())
            && $file->getClientOriginalExtension() != $file->extension()) {
            log::Info("Original extension and extension detected by mime type mismatch");
            return false;
        }

        // Verify if file type exists in BD
        $file_type = FileType::where('name', '=', $file->getClientOriginalExtension())->first();
        if ($file_type == null) {
            log::Info("File type not found in BD");
            return false;
        }

        // Validate file type with mime type
        /*if (!self::is_valid_file_mime_type($file, $file_type->mime_type)) {
            log::Info("Invalid file mime type");
            return false;
        }*/

        // $file->extension() = Determine the file's extension based on the file's MIME type
        // Check matching file type with file extension
        if (self::is_file_type_detected($file->getClientOriginalExtension())
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
            //return Storage::url(File::PUBLIC_FILE_STORAGE_PATH . $file->directory . '/' . $file->hash);
            /*return env('APP_FILE_STORAGE_FULL_PATH', '/www/var/')
                . File::PUBLIC_FILE_STORAGE_PATH . $file->directory . '/' . $file->hash;*/
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
