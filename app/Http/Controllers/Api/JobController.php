<?php

namespace App\Http\Controllers\Api;

use App\Constants\EventTypes;
use App\Constants\JobStatus;
use App\Events\JobAssignedEvent;
use App\Events\JobClosedEvent;
use App\Events\JobCreatedEvent;
use App\Events\JobStatusUpdatedEvent;
use App\Events\JobUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobAssignWorkerRequest;
use App\Http\Requests\JobRatingRequest;
use App\Http\Requests\JobRequest;
use App\Http\Requests\JobStatusRequest;
use App\Http\Resources\JobResource;
use App\Models\Event;
use App\Models\File;
use App\Models\Job;
use Illuminate\Support\Facades\Log;

// php artisan websockets:serve --host=127.0.0.1
// -> to communicate only on localhost that is possible, wait and see if it works
// php artisan websockets:serve --port=3030
// -> TODO: define an port for websockets 80 or 443 -> perhaps 8000

class JobController extends Controller
{
    // API Standard function
    public function index()
    {
        Log::info('Job list retrieved');
        return JobResource::collection(Job::all());
    }

    public function show(int $id)
    {
        Log::info('Job with id ' . $id . ' retrieved');
        return new JobResource(Job::findOrFail($id));
    }

    public function store(JobRequest $request)
    {
        $req_validated = $request->validated();

        // Verify if user has already max job submitted limit
        if (Job::get_client_jobs($request->client_username)->count() >= Job::JOBS_SUBMITTED_LIMIT) {
            Log::info('Client with username ' . $request->client_username . ' has already max jobs submitted');
            return response()->json([
                'message' => 'You have reached the maximum number of jobs you can submit',
            ], 400);
        }

        $job = Job::create($req_validated);

        // Add files to job
        if ($request->has('files')) {
            $files = $request->file('files');
            foreach ($files as $req_file) {
                File::store_file($req_file, $job->id);
            }
        }

        // Create and save Event for client timeline
        Event::create([
            'type' => EventTypes::STATUS,
            'to_notify' => false,
            'data' => JobStatus::NEW,
            'user_username' => $job->client_username,
            'job_id' => $job->id
        ]);

        // Create and save Event (notify worker)
        if ($job->worker_username != null) {
            Event::create([
                'type' => EventTypes::STATUS,
                'to_notify' => true,
                'data' => JobStatus::ASSIGNED,
                'user_username' => $job->worker_username,
                'job_id' => $job->id
            ]);

            $job->status = JobStatus::ASSIGNED;
            $job->save();

            // Notifications
            broadcast(new JobAssignedEvent($job));
        } else {
            // Notifications
            broadcast(new JobCreatedEvent($job));
        }

        if ($job->validator_username != null) {
            $job->status = JobStatus::VALIDATED;
            $job->save();
        }

        Log::info('Job created: ' . $job->title);

        return new JobResource($job);
    }

    // Manage files update only via files route
    // Here only job info are updated
    public function update(JobRequest $request)
    {
        $req_validated = $request->validated();

        $job = Job::findOrFail($request->id);

        // Notifications
        broadcast(new JobUpdatedEvent($job));

        $job->update($req_validated);

        Log::info('Job updated: ' . $job->title);

        return new JobResource($job);
    }

    public function destroy(int $id)
    {
        Job::findOrFail($id)->delete();
        Log::info('Job with id ' . $id . ' deleted');
        return response()->json([
            'message' => "Job deleted successfully!"
        ], 200);
    }

    // Other functions
    public function unassigned_jobs()
    {
        Log::info('Unassigned Job list retrieved');
        return JobResource::collection(Job::get_unassigned_jobs());
    }

    public function user_jobs(string $username)
    {
        Log::info('User Job list retrieved');
        return JobResource::collection(Job::get_user_jobs($username));
    }

    public function user_as_client_jobs(string $username)
    {
        Log::info('User as client Job list retrieved');
        return JobResource::collection(Job::get_client_jobs($username));
    }

    public function user_as_worker_jobs(string $username)
    {
        Log::info('User as worker Job list retrieved');
        return JobResource::collection(Job::get_worker_jobs($username));
    }

    public function user_as_validator_jobs(string $username)
    {
        Log::info('User as validator Job list retrieved');
        return JobResource::collection(Job::get_validator_jobs($username));
    }

    public function assign(JobAssignWorkerRequest $request)
    {
        $req_validated = $request->validated();

        // Verify if user has already max job assigned limit
        if (Job::get_worker_jobs($request->worker_username)->count() >= Job::JOBS_ASSIGNED_LIMIT) {
            Log::info('Worker with username ' . $request->worker_username . ' has already max jobs assigned');
            return response()->json([
                'message' => 'You have reached the maximum number of jobs you can assigned to yourself',
            ], 400);
        }

        $job = Job::findOrFail($request->id);

        // Verify if job is unassigned
        if ($job->worker_username != null) {
            Log::info('Job with id ' . $job->id . ' is already assigned');
            return response()->json([
                'message' => "Job is already assigned to a worker!"
            ], 400);
        }

        $job->update($req_validated);

        // Update status
        $job->status = JobStatus::ASSIGNED;
        $job->save();

        // Notifications
        broadcast(new JobAssignedEvent($job))->toOthers();

        // Create and save Event (notify client)
        Event::create([
            'type' => EventTypes::STATUS,
            'to_notify' => true,
            'data' => JobStatus::ASSIGNED,
            'user_username' => $job->client_username,
            'job_id' => $job->id
        ]);

        // Emails
        Event::create_mail_job($job->client_username);

        Log::info('Job assigned: ' . $job->title . ' to worker: ' . $job->worker_username);

        return new JobResource($job);
    }

    public function update_status(JobStatusRequest $request)
    {
        $req_validated = $request->validated();

        $job = Job::findOrFail($request->id);
        $job->update($req_validated);

        // Notifications
        broadcast(new JobStatusUpdatedEvent($job)); //->toOthers();

        // Create and save Event (notify client)
        Event::create([
            'type' => EventTypes::STATUS,
            'to_notify' => true,
            'data' => $job->status,
            'user_username' => $job->client_username,
            'job_id' => $job->id
        ]);

        // Emails
        Event::create_mail_job($job->client_username);

        Log::info('Job status updated: ' . $job->title . ' to status: ' . $job->status);

        return new JobResource($job);
    }

    public function update_rating(JobRatingRequest $request)
    {
        $req_validated = $request->validated();

        $job = Job::findOrFail($request->id);

        // Verify if job is assigned
        if ($job->worker_username == null) {
            Log::info('Job with id ' . $job->id . ' is not assigned');
            return response()->json([
                'message' => "You can't rate of a job that has no worker assigned!"
            ], 400);
        }

        if ($job->status != JobStatus::COMPLETED) {
            Log::info('Job with id ' . $job->id . ' is not completed');
            return response()->json([
                'message' => "You can't rate of a job that is not completed!"
            ], 400);
        }

        // TODO: do we suppress files and message if completed?

        // Update rating
        $job->update($req_validated);

        // Update status
        $job->status = JobStatus::CLOSED;
        $job->save();

        // Notifications
        broadcast(new JobClosedEvent($job)); //->toOthers();

        // Create and save Event (notify worker)
        Event::create([
            'type' => EventTypes::STATUS,
            'to_notify' => true,
            'data' => JobStatus::CLOSED,
            'user_username' => $job->worker_username,
            'job_id' => $job->id
        ]);

        // Emails
        Event::create_mail_job($job->worker_username);

        Log::info('Job rating updated: ' . $job->title . ' to rating: ' . $job->rating);

        return new JobResource($job);
    }

    // Called when a user has checked the job and needs to remove the notify flag
    // We assume that when a user has seen a job, he has seen all messages, new files and new status
    public function update_notifications(int $id, string $username)
    {
        $job = Job::findOrFail($id);

        // All events of job given are updated
        $events = Event::where('job_id', $job->id)
            ->where('user_username', $username)
            ->get();

        foreach ($events as $event) {
            $event->to_notify = false;
            $event->save();
            //$event->delete();
        }

        Log::info('Job notifications updated: ' . $job->title);

        return $job;
    }
}
