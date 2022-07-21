<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileTypeRequest;
use App\Http\Resources\FileTypeResource;
use App\Models\FileType;
use Illuminate\Support\Facades\Log;

class FileTypeController extends Controller
{
    // API Standard function
    public function index()
    {
        Log::info('File Type list retrieved');
        return FileTypeResource::collection(FileType::all());
    }

    public function show(int $id)
    {
        Log::info('File Type with id ' . $id . ' retrieved');
        return new FileTypeResource(FileType::findOrFail($id));
    }

    public function store(FileTypeRequest $request)
    {
        $file_type = FileType::create($request->validated());
        Log::info('File Type created: ' . $file_type->name);
        return new FileTypeResource($file_type);
    }

    public function update(FileTypeRequest $request)
    {
        $req_validated = $request->validated();
        $file_type = FileType::findOrFail($request->id);
        $file_type->update($req_validated);
        Log::info('File Type updated: ' . $file_type->name);
        return new FileTypeResource($file_type);
    }

    public function destroy(int $id)
    {
        FileType::findOrFail($id)->delete();

        Log::info('File Type with id ' . $id . ' deleted');

        return response()->json([
            'message' => "FileType deleted successfully!"
        ], 200);
    }
}
