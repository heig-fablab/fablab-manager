<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Constants\EventTypes;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hash',
        'directory',
        'file_type_id',
        'job_id'
    ];

    // Has one
    public function job_category()
    {
        return $this->hasOne(JobCategory::class);
    }

    // Belongs to
    public function file_type()
    {
        return $this->belongsTo(FileType::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    // File Storage Service
    public const FILE_STORAGE_PATH = 'FileStorage/';
    public const HASH_ALGORITHME = 'sha256';

    private static function create_event_and_mail(int $job_id)
    {
        // Create and save Event (notify worker)
        $user_to_notify_switch_uuid = Job::findOrFail($job_id)->worker_switch_uuid;

        if ($user_to_notify_switch_uuid != null) {
            Event::create([
                'type' => EventTypes::FILE,
                'to_notify' => true,
                'user_switch_uuid' => $user_to_notify_switch_uuid,
                'job_id' => $job_id
            ]);

            // Emails
            Event::create_mail_job($user_to_notify_switch_uuid);
        }
    }

    public static function is_valid_file($file, $accepted_mime_types): bool
    {
        if ($file == null) {
            return false;
        }

        // Size is in bytes 100'000'000 B
        if ($file->getSize() > 100000000) {
            return false;
        }

        if ($file->getClientOriginalExtension() != $file->extension()) {
            return false;
        }

        // Verify if file type exists in BD
        $file_type = FileType::where('name', '=', $file->getClientOriginalExtension())->first();
        if ($file_type == null) {
            return false;
        }

        // $file->extension() = Determine the file's extension based on the file's MIME type
        // Check matching file type with file extension
        if ($file_type->mime_type != $file->extension()) {
            return false;
        }

        // Verify accepted types
        return in_array($file->extension(), $accepted_mime_types);
    }

    public static function get_file(File $file)
    {
        return Storage::download(File::FILE_STORAGE_PATH . $file->directory . '/' . $file->hash, $file->name);
    }

    public static function store_file($req_file, $job_id)
    {
        // File infos
        $hash = hash_file(File::HASH_ALGORITHME, $req_file);
        $dir = substr($hash, 0, 2);
        $file_type = FileType::where('name', '=', $req_file->getClientOriginalExtension())->firstOrFail();

        Log::debug('File name: ' . $req_file->getClientOriginalName());
        Log::debug('File extension: ' . $req_file->getClientOriginalExtension());
        Log::debug('File hash: ' . $hash);
        Log::debug('File directory: ' . $dir);

        // Create file for DB
        $file = File::create([
            'name' => $req_file->getClientOriginalName(),
            'hash' => $hash,
            'directory' => $dir,
            'file_type_id' => $file_type->id,
            'job_id' => $job_id,
        ]);

        File::create_event_and_mail($job_id);

        // Add to filestorage
        // Create a directory with 2 first letter of hashed_name
        // It's a Laravel trick to not be stopped after x files in directory
        $req_file->storeAs(File::FILE_STORAGE_PATH . $dir, $hash);

        return $file;
    }

    public static function update_file(File $file, $req_file, int $req_job_id)
    {
        $hash = hash_file(File::HASH_ALGORITHME, $req_file);
        $dir = substr($hash, 0, 2);

        if ($hash != $file->hash || $dir != $file->directory) {
            // Delete old file
            File::delete_file($file);

            // Create new file
            $req_file->storeAs(File::FILE_STORAGE_PATH . $dir, $hash);

            // Update file infos linked to physic file content for BD
            $file_type = FileType::where('name', '=', $req_file->getClientOriginalExtension())->firstOrFail();
            $file->hash = $hash;
            $file->directory = $dir;
            $file->file_type_id = $file_type->id;

            File::create_event_and_mail($req_job_id);
        }

        // Update file infos for BD
        $file->name = $req_file->getClientOriginalName();
        $file->job_id = $req_job_id;

        return $file;
    }

    public static function delete_file(File $file)
    {
        Storage::delete(File::FILE_STORAGE_PATH . $file->directory . '/' . $file->hash);

        // Delete only empty folder
        if (Storage::exists(File::FILE_STORAGE_PATH . $file->directory)) {
            Storage::deleteDirectory(File::FILE_STORAGE_PATH . $file->directory);
        }
    }
}
