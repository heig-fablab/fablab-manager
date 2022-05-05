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
        return new JobResource(Job::findOrFail($id));
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
    public function user_jobs($email)
    {
        return JobResource::collection(Job::get_user_jobs($email));
    }

    public function user_as_requestor_jobs($email)
    {
        return JobResource::collection(Job::get_requestor_jobs($email));
    }
    
    public function user_as_worker_jobs($email)
    {
        return JobResource::collection(Job::get_worker_jobs($email));
    }

    public function user_as_validator_jobs($email)
    {
        return JobResource::collection(Job::get_validator_jobs($email));
    }
}
