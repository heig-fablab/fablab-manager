<?php

namespace App\Http\Controllers\Api;

use App\Events\JobFileUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    // API Standard function
    public function show(int $id)
    {
        Log::info('File with id ' . $id . ' retrieved');
        return new FileResource(File::findOrFail($id));
    }

    public function store(FileRequest $request)
    {
        $request->validated();

        $file = File::store_file($request->file('file'), $request->job_id);

        Log::Info('File uploaded: ' . $file->name);

        return new FileResource($file);
    }

    public function update(FileRequest $request)
    {
        $request->validated();

        log::Debug('Update file request');

        $file = File::findOrFail($request->id);
        $file = File::update_file($file, $request->file('file'));
        $file->save();

        Log::Info('File updated: ' . $file->name);

        return new FileResource($file);
    }

    public function destroy(int $id)
    {
        $file = File::findOrFail($id);

        // Verify if only this DB file using this physic file
        $same_files = File::where('hash', $file->hash)->get();
        if ($same_files->count() == 1) {
            File::delete_file($file);
        }

        $file->delete();

        Log::info('File with id ' . $id . ' deleted');

        return response()->json([
            'message' => "File deleted successfully!"
        ], 200);
    }

    // Other functions
    public function download(int $id)
    {
        Log::info('File with id ' . $id . ' downloaded');

        return File::download_file(File::findOrFail($id));
    }
}
