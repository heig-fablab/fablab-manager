<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'hash',
        'directory',
        'file_type_id',
        'job_id'
    ];

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
    private static function file_storage_path()
    {
        return 'FileStorage/';
    }

    private static function hash_algo()
    {
        return 'sha256';
    }

    public static function validate_file(Request $request)
    {
        // TODO


        /*$request->validate([
            'file' => 'required|file|max:2048',
            'job_id' => 'required|integer',
        ]);*/

        // TODO: verify mime_type via ->extension()
        // TODO: verify file_type via ->getClientOriginalExtension
        /* function ($attribute, $value, $fail) {
        if ($value === 'foo') {
            $fail('The '.$attribute.' is invalid.');
        }
        },*/ // use closure to test extension types of files
        //$extension = $file->extension(); // Determine the file's extension based on the file's MIME type...
    }

    public static function get_file(File $file)
    {
        return Storage::download(File::file_storage_path() . $file->directory . '/' . $file->hash, $file->name);
    }

    public static function store_file($req_file, $job_id)
    {
        // File infos
        $hash = hash_file(File::hash_algo(), $req_file);
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

        // Add to filestorage
        // Create a directory with 2 first letter of hashed_name
        // It's a Laravel trick to not be stopped after x files in directory
        $req_file->storeAs(File::file_storage_path() . $dir, $hash);

        return $file;
    }

    public static function update_file(File $file, $req_file, $req_job_id)
    {
        $hash = hash_file(File::hash_algo(), $req_file);
        $dir = substr($hash, 0, 2);

        if ($hash != $file->hash || $dir != $file->directory) {
            // Delete old file
            File::delete_file($file);

            // Create new file
            $req_file->storeAs(File::file_storage_path() . $dir, $hash);

            // Update file infos linked to physic file content for BD
            $file_type = FileType::where('name', '=', $req_file->getClientOriginalExtension())->firstOrFail();
            $file->hash = $hash;
            $file->directory = $dir;
            $file->file_type_id = $file_type->id;
        }

        // Update file infos for BD
        $file->name = $req_file->getClientOriginalName();
        $file->job_id = $req_job_id;

        return $file;
    }

    public static function delete_file(File $file)
    {
        Storage::delete(File::file_storage_path() . $file->directory . '/' . $file->hash);

        // Delete only empty folder
        if (Storage::exists(File::file_storage_path() . $file->directory)) {
            Storage::deleteDirectory(File::file_storage_path() . $file->directory);
        }
    }
}
