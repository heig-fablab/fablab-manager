<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileStorageService extends Model
{
    use HasFactory;

    private static $fileStoragePath = 'FileStorage/';
    private static $hash_algo = 'sha256';

    public static function getFile(File $file)
    {
        return Storage::download($fileStoragePath.$file->directory.$file->hash, $file->name);
    }

    public function store_file($request_file, $job_id) {
        // File infos
        $hash = hash_file($hash_algo, $request_file);
        $dir = substr($hash, 0, 2);
        $file_type = FileType::where('name', '=', $request_file->getClientOriginalExtension())->firstOrFail();

        // Create directory with 2 first letter of hashed_name
        Storage::makeDirectory($dir);

        // Add to DB
        $file = File::create([
            'name' => $request_file->getClientOriginalName(),
            'directory' => $dir,
            'hash' => $hash,
            'job_id' => $job_id,
            'file_type_id' => $file_type->id,
        ]);

        // Add to filestorage
        $file_to_upload->storeAs($fileStoragePath.$dir, $hash);

        return $file;
    }

    public function update_file(File $file) {
        // TODO
    }

    public function delete_file(File $file) {
        Storage::delete($fileStoragePath.$file->directory.$file->hash);
    }
}
