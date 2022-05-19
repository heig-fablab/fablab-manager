<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreJobRequest;
use App\Http\Requests\UpdateRequests\UpdateJobRequest;
use App\Http\Requests\UpdateRequests\UpdateJobAssignWorkerRequest;
use App\Http\Requests\UpdateRequests\UpdateJobStatusRequest;
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
        // TODO: verify $id input

        $job = Job::findOrFail($id);
        return new JobResource($job);
    }

    public function store(StoreJobRequest $request)
    {
        // TODO: add event

        // TODO: add files

        $job = Job::create($request->validated());

        //Notify all the technicians that a new job is available. Then don't need the timeline and files
        //broadcast(new JobPusherEvent($newJob, 0))->toOthers();

        return new JobResource($job);
    }

    public function update(UpdateJobRequest $request)
    {
        $req_validated = $request->validated();

        $job = Job::findOrFail($req_validated->id);
        $job->update($req_validated);
        return new JobResource($job);
    }

    public function destroy($id)
    {
        // TODO: verify $id input

        Job::findOrFail($id)->delete();
        return response()->json([
            'message' => "Job deleted successfully!"
        ], 200);
    }

    // Others function
    public function unassigned_jobs()
    {
        //TODO: The timeline, files and messages must be attached to each job as additional properties
        return JobResource::collection(Job::get_unassigned_jobs());
    }

    public function user_jobs($switch_uuid)
    {
        // TODO: verify $switch_uuid input

        return JobResource::collection(Job::get_user_jobs($switch_uuid));
    }

    public function user_as_client_jobs($switch_uuid)
    {
        // TODO: verify $switch_uuid input

        return JobResource::collection(Job::get_client_jobs($switch_uuid));
    }
    
    public function user_as_worker_jobs($switch_uuid)
    {
        // TODO: verify $switch_uuid input

        return JobResource::collection(Job::get_worker_jobs($switch_uuid));
    }

    public function user_as_validator_jobs($switch_uuid)
    {
        // TODO: verify $switch_uuid input

        return JobResource::collection(Job::get_validator_jobs($switch_uuid));
    }

    public function assign_worker(UpdateJobAssignWorkerRequest $request)
    {
        $req_validated = $request->validated();

        // Update worker
        $job = Job::findOrFail($request->id);
        $job->update($req_validated);

        // Update status
        $job->status = 'assigned';
        $job->save();

        return new JobResource($job);
    }

    public function update_status(UpdateJobStatusRequest $request)
    {
        $req_validated = $request->validated();

        $job = Job::findOrFail($request->id);

        // Define rating
        $updated_rating = $request->rating; 
        if ($request->status == 'completed' && $updated_rating == null) {
            $updated_rating = 6;
        }

        // TODO: do we suppress files and message if completed?
        
        // Update status
        $job->update($req_validated);

        // Update rating
        $job->rating = $updated_rating;
        $job->save();

        return new JobResource($job);
    }
}
