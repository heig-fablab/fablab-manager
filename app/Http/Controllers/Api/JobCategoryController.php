<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobCategoryRequest;
use App\Http\Resources\JobCategoryResource;
use App\Models\File;
use App\Models\FileType;
use App\Models\JobCategory;
use Illuminate\Support\Facades\Log;

class JobCategoryController extends Controller
{
    // API Standard function
    public function index()
    {
        $job_categories = JobCategory::all();
        Log::info('Job Category list retrieved');
        return JobCategoryResource::collection($job_categories);
    }

    public function show(int $id)
    {
        Log::info('Job Category with id ' . $id . ' retrieved');
        return new JobCategoryResource(JobCategory::findOrFail($id));
    }

    public function store(JobCategoryRequest $request)
    {
        $job_category = JobCategory::create($request->validated());

        foreach ($request->file_types as $file_type_name) {
            $job_category->file_types()->attach(FileType::where('name', $file_type_name)->first()->id);
        }

        // Add image of the job category
        $file = File::store_file($request->file('image'), null, true);
        $file->job_category_id = $job_category->id;
        $file->save();

        Log::info('Job Category created: ' . $job_category->name);

        return new JobCategoryResource($job_category);
    }

    public function update(JobCategoryRequest $request)
    {
        $req_validated = $request->validated();
        $job_category = JobCategory::findOrFail($request->id);

        $job_category_acronym_exists = JobCategory::where('acronym', $request->acronym)->first();

        if ($job_category_acronym_exists != null && $job_category_acronym_exists != $job_category) {
            return response()->json([
                'message' => "New acronym is already used by an other job category!"
            ], 400);
        }

        // Update image of the job category
        if ($job_category->file == null) {
            $file = File::store_file($request->file('image'), null, true);
        } else {
            $file = File::update_file($job_category->file, $request->file('image'), true);
        }
        $file->job_category_id = $job_category->id;
        $file->save();

        // Update job file types accepted for the job category
        $job_category->file_types()->detach();
        foreach ($request->file_types as $file_type_name) {
            $job_category->file_types()->attach(FileType::where('name', $file_type_name)->first()->id);
        }

        $job_category->update($req_validated);

        Log::info('Job Category updated: ' . $job_category->name);

        return new JobCategoryResource($job_category);
    }

    public function destroy(int $id)
    {
        $job_category = JobCategory::findOrFail($id);
        File::delete_file($job_category->file);
        $job_category->delete();

        Log::info('Job Category with id ' . $id . ' deleted');

        return response()->json([
            'message' => "Job category deleted successfully!"
        ], 200);
    }

    // Other functions
    public function image(int $id)
    {
        $job_category = JobCategory::findOrFail($id);
        return File::get_file_url($job_category->file);
    }
}
