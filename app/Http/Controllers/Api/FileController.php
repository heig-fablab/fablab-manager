<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\FileType;
use App\Models\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{   
    protected $file_storage_service;
 
    public function __construct(FileStorageService $file_storage_service)
    {
        $this->file_storage_service = $file_storage_service;
    }

    // API Standard function
    /*public function index()
    {
        return FileResource::collection(File::all());
    }*/

    public function show($id)
    {
        $file = File::findOrFail($id);
        $file->file = $file_storage_service->getFile($file);
        return new FileResource($file);
    }

    public function store(StoreFileRequest $request)
    {
        // old code adapted -> doens't work
        /*$file = $request->file('file');
        $newFile = new File;
        $newFile->hash = hash_file('sha256', $file);
        $newFile->name = $file->getClientOriginalName();
        $newFile->job_id = $request->job_id;
        $newFile->directory = 'test';
        $newFile->save();
        $file->storeAs('FileStorage', hash_file('sha256', $file));*/

        $validated = $request->validated();

        $file = $file_storage_service->store_file($request->file, $request->job_id);

        // Event
        // TODO

        return new FileResource($file);
    }

    public function update(StoreFileRequest $request)
    {
        $file = File::findOrFail($request->id);
        $file->update($request->validated());
        $file_storage_service->update_file($file);
        return new FileResource($file);
    }

    public function destroy($id)
    {
        $file = File::findOrFail($id);
        $file_storage_service->delete_file($file);
        $file->delete();

        return response()->json([
            'message' => "File deleted successfully!"
        ], 200);
    }

    // Other functions
    /*public function job_files(StoreFileRequest $request)
    {
        // TODO: perhaps
        foreach($request->files as $file) {

        }
    }*/
}
