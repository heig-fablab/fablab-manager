<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Models\Event;
use App\Events\JobFileUpdatedEvent;
use Illuminate\Http\Request;

class FileController extends Controller
{   
    public function show($id)
    {
        // TODO: validate $id input

        $file = File::findOrFail($id);
        $file->file = File::get_file($file);
        return new FileResource($file);
    }

    // Request values:
    // $job_id -> id of the job linked to the file
    // $file -> file to add
    public function store(Request $request)
    {
        // TODO: validation in model and not store request cause doen'st work

        $file = File::store_file($request->file, $request->job_id);
        $file->save();

        // Notifications
        broadcast(new JobFileUpdatedEvent($file->job));//->toOthers();

        // OLD code
        //$interlocutor = $request->user()->is_technician ? $job->client_id : $job->technician_id;
        //broadcast(new JobPusherEvent($job, $interlocutor))->toOthers();

        // Create and save Event (notify worker)
        $event = Event::create([
            'type' => 'file',
            'to_notify' => true,
            'user_switch_uuid' => Job::findOrFail($request->job_id)->worker_switch_uuid,
            'job_id' => $request->job_id
        ]);

        // Emails

        //OLD code
        /*$job->notify_technician = true;
        $job->notify_client = true;
        $job->save();
        $interlocutor = $request->user()->is_technician ? $job->client_id : $job->technician_id;
        NotifyEmailController::dispatchMailJob($interlocutor);*/

        return new FileResource($file);
    }

    // Request values:
    // $id -> id of the file to be updated
    // $job_id -> id of the job linked to the file
    // $file -> file to be updated
    public function update(Request $request)
    {
        // TODO: validation in model and not store request cause doen'st work

        $file = File::findOrFail($request->id);
        $file = File::update_file($file, $request->file, $request->job_id);
        $file->save();

        // Notifications
        broadcast(new JobFileUpdatedEvent($file->job));//->toOthers();

        // OLD code
        //$interlocutor = $request->user()->is_technician ? $job->client_id : $job->technician_id;
        //broadcast(new JobPusherEvent($job, $interlocutor))->toOthers();

        // Create and save Event (notify worker)
        $event = Event::create([
            'type' => 'file',
            'to_notify' => true,
            'user_switch_uuid' => Job::findOrFail($request->job_id)->worker_switch_uuid,
            'job_id' => $request->job_id
        ]);


        // Emails

        //OLD code
        /*$job->notify_technician = true;
        $job->notify_client = true;
        $job->save();
        $interlocutor = $request->user()->is_technician ? $job->client_id : $job->technician_id;
        NotifyEmailController::dispatchMailJob($interlocutor);*/

        return new FileResource($file);
    }

    public function destroy($id)
    {
        // TODO: validate $id input

        $file = File::findOrFail($id);

        // Verify if only db file using this physic file
        $same_files = File::where('hash', $file->hash)->get();
        if ($same_files->count() == 1) {
            File::delete_file($file);
        }

        $file->delete();

        return response()->json([
            'message' => "File deleted successfully!"
        ], 200);
    }
}
