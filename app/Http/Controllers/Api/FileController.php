<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Http\Requests\StoreRequests\StoreFileRequest;
use App\Http\Requests\UpdateRequests\UpdateFileRequest;
use App\Models\File;
use App\Events\JobFileUpdatedEvent;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    // API Standard function
    public function show(int $id)
    {
        return new FileResource(File::findOrFail($id));
    }

    public function store(StoreFileRequest $request)
    {
        $request->validated();

        $file = File::store_file($request->file('file'), $request->job_id);

        // Notifications
        broadcast(new JobFileUpdatedEvent($file->job)); //->toOthers();

        return new FileResource($file);
    }

    public function update(UpdateFileRequest $request)
    {
        $request->validated();

        log::Debug('Update file request');

        $file = File::findOrFail($request->id);
        $file = File::update_file($file, $request->file('file'));
        $file->save();

        // Notifications
        broadcast(new JobFileUpdatedEvent($file->job)); //->toOthers();

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

        return response()->json([
            'message' => "File deleted successfully!"
        ], 200);
    }

    // Other functions
    public function download(int $id)
    {
        return File::download_file(File::findOrFail($id));
    }
}
