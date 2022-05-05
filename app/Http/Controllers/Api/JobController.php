<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // TODO: perhaps dependance injection -> https://laravel.com/docs/9.x/controllers#dependency-injection-and-controllers

    // API Standard function
    public function index()
    {
        return JobResource::collection(Job::all());
    }

    public function show($id)
    {
        $job = Job::findOrFail($id);
        // TODO: add others values from relations
        return new JobResource($job);
    }

    public function store(StoreJobRequest $request)
    {
        $job = Job::create($request->validated());
        return new JobResource($job);
    }

    public function update(StoreJobRequest $request)
    {
        $job = Job::findOrFail($request->id);
        $job->update($request->validated());
        return new JobResource($job);
    }

    public function destroy($id)
    {
        Job::findOrFail($id)->delete();
        return response()->json([
            'message' => "Job deleted successfully!"
        ], 200);
    }

    // Others function
    public function user_jobs($switch_uuid)
    {
        return JobResource::collection(Job::get_user_jobs($switch_uuid));
    }

    public function user_as_client_jobs($switch_uuid)
    {
        return JobResource::collection(Job::get_client_jobs($switch_uuid));
    }
    
    public function user_as_worker_jobs($switch_uuid)
    {
        return JobResource::collection(Job::get_worker_jobs($switch_uuid));
    }

    public function user_as_validator_jobs($switch_uuid)
    {
        return JobResource::collection(Job::get_validator_jobs($switch_uuid));
    }
}
