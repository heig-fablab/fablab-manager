<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileTypeRequest;
use App\Http\Resources\FileTypeResource;
use App\Models\FileType;

class FileTypeController extends Controller
{
    // API Standard function
    public function index()
    {
        $file_types = FileType::all();
        return FileTypeResource::collection($file_types);
    }

    public function show(int $id)
    {
        return new FileTypeResource(FileType::findOrFail($id));
    }

    public function store(FileTypeRequest $request)
    {
        $file_type = FileType::create($request->validated());
        return new FileTypeResource($file_type);
    }

    public function update(FileTypeRequest $request)
    {
        $req_validated = $request->validated();
        $file_type = FileType::findOrFail($request->id);
        $file_type->update($req_validated);
        return new FileTypeResource($file_type);
    }

    public function destroy(int $id)
    {
        FileType::findOrFail($id)->delete();
        return response()->json([
            'message' => "FileType deleted successfully!"
        ], 200);
    }
}
