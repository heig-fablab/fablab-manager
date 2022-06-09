<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreJobRequest;
use App\Http\Requests\UpdateRequests\UpdateJobRequest;
use App\Http\Requests\UpdateRequests\UpdateJobAssignWorkerRequest;
use App\Http\Requests\UpdateRequests\UpdateJobStatusRequest;
use App\Http\Requests\UpdateRequests\UpdateJobRatingRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Events\JobAssignedEvent;
use App\Events\JobCreatedEvent;
use App\Events\JobStatusUpdatedEvent;
use App\Events\JobTerminatedEvent;
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
        // TODO: add files
        /*foreach($request_files as $file) {
            File::store_file($file, $request->job_id);
            // TODO: add event
        }*/

        // TODO: for each file -> new event

        $job = Job::create($request->validated());

        // Notifications
        broadcast(new JobCreatedEvent($job));
        //broadcast(new JobCreatedEvent($job))->toOthers();

        // OLD code
        //Notify all the technicians that a new job is available. Then don't need the timeline and files
        //broadcast(new JobPusherEvent($newJob, 0))->toOthers();

        // toOthers() send to all subscribers without selected

        // Create and save Event (notify worker)
        $event = Event::create([
            'type' => Event::$TYPE_STATUS,
            'to_notify' => true,
            'data' => 'new',
            'user_switch_uuid' => $job->worker_switch_uuid,
            'job_id' => $job->id
        ]);

        return new JobResource($job);
    }

    public function update(UpdateJobRequest $request)
    {
        $req_validated = $request->validated();

        // TODO: manage files update -> only via files route
        // here only job info

        // Notifications
        // TODO
        //broadcast(new JobCreatedEvent($job));
        //broadcast(new JobCreatedEvent($job))->toOthers();

        $job = Job::findOrFail($request->id);
        $job->update($req_validated);
        return new JobResource($job);
    }

    public function destroy($id)
    {
        // TODO: verify $id input

        // TODO: only admin or creator?

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
        // TODO: check how validate with request GET params
        // https://laravel.com/docs/9.x/routing#required-parameters

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

    // TODO: perhaps route for assign multiple jobs

    public function assign_worker(UpdateJobAssignWorkerRequest $request)
    {
        $req_validated = $request->validated();

        $job = Job::findOrFail($request->id);

        // Verify if job is unassigned
        if ($job->worker_switch_uuid != null) {
            return response()->json([
                'message' => "Job is already assigned to a worker!"
            ], 400);
        }

        $job->update($req_validated);

        // Update status
        $job->status = 'assigned';
        $job->save();

        // Notifications
        broadcast(new JobAssignedEvent($job))->toOthers();

        // OLD code
        //All technicians are notified that the job has been assigned
        //broadcast(new JobPusherEvent($job, 0))->toOthers();

        // Create and save Event (notify client)
        $event = Event::create([
            'type' => 'status',
            'to_notify' => true,
            'data' => 'assigned',
            'user_switch_uuid' => $job->client_switch_uuid,
            'job_id' => $job->id
        ]);

        // Emails
        Event::create_mail_job($job->client_switch_uuid);

        // OLD code:
        //$job = Job::find($job->id);
        //NotifyEmailController::dispatchMailJob($job->client_id);

        return new JobResource($job);
    }

    public function update_status(UpdateJobStatusRequest $request)
    {
        $req_validated = $request->validated();

        /*if ($req_validated->fails()) {
            return response()->json([
                'message' => "error"
            ], 400);
        }*/

        $job = Job::findOrFail($request->id);

        if ($request->worker_switch_uuid != $job->worker_switch_uuid) {
            return response()->json([
                'message' => "You can't update a job that is not assigned to you!"
            ], 400);
        }

        $job->update($req_validated);

        // Notifications
        broadcast(new JobStatusUpdatedEvent($job));//->toOthers();

        // OLD code
        //broadcast(new JobPusherEvent($job, $job->client_id))->toOthers();

        // Create and save Event (notify client)
        $event = Event::create([
            'type' => 'status',
            'to_notify' => true,
            'data' => $job->status,
            'user_switch_uuid' => $job->client_switch_uuid,
            'job_id' => $job->id
        ]);

        // Emails
        Event::create_mail_job($job->client_switch_uuid);

        // OLD code
        /*$job->status = $request->status;
        $job->notify_technician = false;
        $job->notify_client = true;
        $job->save();
        $job = Job::find($job->id);
        NotifyEmailController::dispatchMailJob($job->client_id);*/

        return new JobResource($job);
    }

    public function update_rating(UpdateJobRatingRequest $request)
    {
        $req_validated = $request->validated();

        $job = Job::findOrFail($request->id);

        if ($job->status != 'completed') {
            return response()->json([
                'message' => "You can't rate of a job that is not completed!"
            ], 400);
        }

        // TODO: do we suppress files and message if completed?

        // Update rating
        $job->update($req_validated);

        // Update status
        $job->status = 'closed';
        $job->save();

        // Notifications
        broadcast(new JobTerminatedEvent($job));//->toOthers();

        // OLD code
        //broadcast(new JobPusherEvent($job, $job->technician_id))->toOthers();

        // Create and save Event (notify worker)
        $event = Event::create([
            'type' => 'status',
            'to_notify' => true,
            'data' => 'closed',
            'user_switch_uuid' => $job->worker_switch_uuid,
            'job_id' => $job->id
        ]);

        // Emails
        Event::create_mail_job($job->worker_switch_uuid);

        return new JobResource($job);
    }

    // TODO: route update notifications
}
