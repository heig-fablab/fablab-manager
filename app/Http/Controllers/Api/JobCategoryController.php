<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreJobCategoryRequest;
use App\Http\Requests\UpdateRequests\UpdateJobCategoryRequest;
use App\Http\Resources\JobCategoryResource;
use App\Models\JobCategory;
use App\Models\FileType;

class JobCategoryController extends Controller
{
    // API Standard function
    public function index()
    {
        $job_categories = JobCategory::all();
        return JobCategoryResource::collection($job_categories);
    }

    public function show(int $id)
    {
        return new JobCategoryResource(JobCategory::findOrFail($id));
    }

    public function store(StoreJobCategoryRequest $request)
    {
        $job_category = JobCategory::create($request->validated());

        $job_category->devices()->attach($request->devices);

        foreach ($request->file_types as $file_type_name) {
            $job_category->file_types()->attach(FileType::where('name', $file_type_name)->first()->id);
        }

        return new JobCategoryResource($job_category);
    }

    public function update(UpdateJobCategoryRequest $request)
    {
        $req_validated = $request->validated();
        $job_category = JobCategory::findOrFail($request->id);

        $job_category_acronym_exists = JobCategory::where('acronym', $request->acronym)->first();

        if ($job_category_acronym_exists != null && $job_category_acronym_exists != $job_category) {
            return response()->json([
                'message' => "New acronym is already used by an other job category!"
            ], 400);
        }

        $job_category->devices()->detach();
        $job_category->file_types()->detach();

        $job_category->devices()->attach($request->devices);

        foreach ($request->file_types as $file_type_name) {
            $job_category->file_types()->attach(FileType::where('name', $file_type_name)->first()->id);
        }

        $job_category->update($req_validated);
        return new JobCategoryResource($job_category);
    }

    public function destroy(int $id)
    {
        JobCategory::find($id)->delete();
        return response()->json([
            'message' => "Job category deleted successfully!"
        ], 200);
    }
}
