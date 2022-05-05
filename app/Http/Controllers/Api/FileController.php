<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    // API Standard function
    public function index()
    {
        return FileResource::collection(File::all());
    }

    public function show($id)
    {
        return new FileResource(File::findOrFail($id));
    }

    public function store(StoreFileRequest $request)
    {
        $file = File::create($request->validated());

        //Storage::disk('local')->put('example.txt', 'Contents');

        /*if (! Storage::put('file.jpg', $contents)) {
            // The file could not be written to disk...
        }*/

        /*$path = $request->file('avatar')->store('avatars');
 
        return $path;*/

        //$path = Storage::putFile('avatars', $request->file('avatar'));

        /*$path = $request->file('avatar')->storeAs(
            'avatars', $request->user()->id
        );*/

        // Verification
        /*$file = $request->file('avatar');
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();*/

        /*
        $file = $request->file('avatar');
        $name = $file->hashName(); // Generate a unique, random name...
        $extension = $file->extension(); // Determine the file's extension based on the file's MIME type...*/

        // todo: filestorage management in model -> use in job (delete files for example)
        // Storage::delete(['file.jpg', 'file2.jpg']);

        return new FileResource($file);
    }

    public function update(StoreFileRequest $request)
    {
        $file = File::findOrFail($request->id);
        $file->update($request->validated());
        return new FileResource($file);
    }

    public function destroy($id)
    {
        File::findOrFail($id)->delete();
        return response()->json([
            'message' => "File deleted successfully!"
        ], 200);
    }
}
