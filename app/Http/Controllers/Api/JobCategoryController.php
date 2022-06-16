<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreJobCategoryRequest;
use App\Http\Requests\UpdateRequests\UpdateJobCategoryRequest;
use App\Http\Resources\JobCategoryResource;
use App\Models\JobCategory;

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
        // TODO: validate $id input
        return new JobCategoryResource(JobCategory::findOrFail($id));
    }

    public function store(StoreJobCategoryRequest $request)
    {
        $job_category = JobCategory::create($request->validated());
        $job_category->devices()->attach($request->devices);
        $job_category->file_types()->attach($request->file_types);
        return new JobCategoryResource($job_category);
    }

    public function update(UpdateJobCategoryRequest $request)
    {
        $req_validated = $request->validated();
        $job_category = JobCategory::findOrFail($request->id);
        $job_category->devices()->detach();
        $job_category->file_types()->detach();
        $job_category->devices()->attach($request->devices);
        $job_category->file_types()->attach($request->file_types);
        $job_category->update($req_validated);
        return new JobCategoryResource($job_category);
    }

    public function destroy(int $id)
    {
        // TODO: validate $id input
        JobCategory::find($id)->delete();
        return response()->json([
            'message' => "Job category deleted successfully!"
        ], 200);
    }
}
