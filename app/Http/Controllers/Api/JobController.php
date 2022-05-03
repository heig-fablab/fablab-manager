<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return JobResource::collection(Job::all());
    }

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new JobResource(Job::findOrFail($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobRequest $request)
    {
        $job = Job::create($request->validated());
        //$request->requestor_email
        return new JobResource($job);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(StoreJobRequest $request)
    {
        $job = Job::find($request->id);
        $job->update($request->validated());
        return new JobResource($job);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        Job::find($id)->delete();
        return response()->json([
            'message' => "Job deleted successfully!"
        ], 200);
    }
}
