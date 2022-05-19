<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{   
    public function show($id)
    {
        // TODO: validate $id input

        $file = File::findOrFail($id);
        //$file->file = $file_storage_service->getFile($file);
        return new FileResource($file);
    }

    public function store(Request $request)
    {
        // TODO: validation in model and not store request cause doen'st work

        $file = File::store_file($request->file, $request->job_id);
        $file->save();

        // TODO: Event

        return new FileResource($file);
    }

    public function update(StoreFileRequest $request)
    {
        // TODO
        
        //$file = File::findOrFail($request->id);
        //$file->update($request->validated());
        //$file_storage_service->update_file($file);
        //return new FileResource($file);
    }

    public function destroy($id)
    {
        // TODO: validate $id input

        $file = File::findOrFail($id);

        // Verify if only db file using this physic file
        $same_files = File::where('hash', $file->hash)->get();
        if ($same_files->count() == 1) {
            File::delete_file($file);
        }

        $file->delete();

        return response()->json([
            'message' => "File deleted successfully!"
        ], 200);
    }
}
