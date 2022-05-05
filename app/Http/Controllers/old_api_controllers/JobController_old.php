<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Job;
use App\Models\User;
use App\Models\File;
use App\Models\TimelineEvent;
use App\Models\Message;
use App\Events\JobPusherEvent;
use App\Http\Controllers\NotifyEmailController;


class JobController extends Controller
{
  /*public function index($id, Request $request)//Called when a user wants to retrieve his jobs
  {//input : {id: the user's id}
    $user = $request->user();
    if ($id == 0 && $user->is_technician) {
      $jobs = Job::where('technician_id', null)->get(); //Special case where all the unassigned jobs are retrieved
    } else {
      $jobs = $user->is_technician ? Job::where('technician_id', $user->id)->orWhere('client_id', $user->id)->get() : Job::where('client_id', $user->id)->get();
    }

    foreach ($jobs as $job) {
      //The timeline, files and messages must be attached to each job as additional properties
      $job->files = File::where('job_id', $job->id)->get();
      $job->timeline = TimelineEvent::where('job_id', $job->id)->get();
      $job->messages = Message::where('job_id', $job->id)->get();
    }

    return $jobs;
  }//return : the jobs array with their full timeline, full files and full messages arrays

  public function store(Request $request)//Called when a new job is submitted
  {//input : {client_id: client's id, job_type: one of the available job types, deadline: JSON deadline date, description: comment, uploadedFiles: [associated files]}
    $user = $request->user();
    $newJob = new Job;
    $newJob->client_id = $request->client_id;
    $newJob->job_type = $request->job_type;
    $newJob->deadline = $request->deadline;
    $newJob->description = $request->description;
    $newJob->client_name = $user->name;
    $newJob->client_surname = $user->surname;
    $newJob->save();
    $newJob = Job::find($newJob->id);

    $newTimelineEvent = new TimelineEvent;
    $newTimelineEvent->job_id = $newJob->id;
    $newTimelineEvent->type = "status";
    $newTimelineEvent->data = "new";
    $newTimelineEvent->save();

    if (isset($request->uploadedFiles)) {
      foreach ($request->uploadedFiles as $file) {
        $newFile = new File;
        $newFile->hashed_name = hash_file('sha256', $file);
        $newFile->name = $file->getClientOriginalName();
        $newFile->job_id = $newJob->id;
        $newFile->save();
        $file->storeAs('FileStorage', hash_file('sha256', $file));

        $newTimelineEvent = new TimelineEvent;
        $newTimelineEvent->job_id = $newJob->id;
        $newTimelineEvent->type = "file";
        $newTimelineEvent->data = $newFile->name;
        $newTimelineEvent->save();
      }
    }

    broadcast(new JobPusherEvent($newJob, 0))->toOthers();  //Notify all the technicians that a new job is available. Then don't need the timeline and files
    //The timeline, files and messages must be attached to each job as additional properties
    $newJob->files = File::where('job_id', $newJob->id)->get();
    $newJob->timeline = TimelineEvent::where('job_id', $newJob->id)->get();
    $newJob->messages = []; //A freshly created job has no messages yet
    return $newJob;
  }//return : the job with it's full timeline, full files and empty messages arrays

  public function updateStatus(Request $request)//Called by a technician, when the job's status is updated
  {//input : {id: job's id, status: the new status}
    $job = Job::find($request->id);
    $job->status = $request->status;
    $job->notify_technician = false;
    $job->notify_client = true;
    $job->save();
    $job = Job::find($job->id);
    NotifyEmailController::dispatchMailJob($job->client_id);

    $newTimelineEvent = new TimelineEvent;
    $newTimelineEvent->job_id = $job->id;
    $newTimelineEvent->type = "status";
    $newTimelineEvent->data = $request->status;
    $newTimelineEvent->notify_technician = false;
    $newTimelineEvent->notify_client = true;
    $newTimelineEvent->save();
    $newTimelineEvent = TimelineEVent::find($newTimelineEvent->id);

    $timeline = array($newTimelineEvent);
    //The job only needs the new TimlineEvent
    $job->timeline = $timeline;
    broadcast(new JobPusherEvent($job, $job->client_id))->toOthers();
    return $job;
  }//return : the job with only a timeline array containing only the new TimelineEvent

  public function updateNotify(Request $request)//Called when a user has checked the job and needs to remove the notify flag
  {//input : {id: job's id}
    $job = Job::find($request->id);
    $request->user()->is_technician ? $job->notify_technician = false : $job->notify_client = false;
    $job->save();
    $job = Job::find($job->id);
    //All of the timeline events are updated
    $timelineEvents = TimelineEvent::where('job_id', $job->id)->get();
    foreach ($timelineEvents as $event) {
      $request->user()->is_technician ? $event->notify_technician = false : $event->notify_client = false;
      $event->save();
    }
    //All of the messages are updated
    $messages = Message::where('job_id', $job->id)->where('recipient_id', $request->user()->id)->get();
    foreach ($messages as $message) {
      $message->notify = false;
      $message->save();
    }

    return $job;
  }//return : the job

  public function assign(Request $request)//Called when a technician has assigned some jobs to himself
  {//input : {idArray: [job's IDs]}
    $user = $request->user();
    $jobArray = array();
    foreach ($request->idArray as $id) {
      $job = Job::find($id);
      if(is_null($job->technician_id)){ //Make sure the job is unassigned
        $job->technician_id = $user->id;
        $job->status = "assigned";
        $job->notify_technician = true;
        $job->notify_client = true;
        $job->technician_name = $user->name;
        $job->technician_surname = $user->surname;
        $job->save();
        $job = Job::find($job->id);
        NotifyEmailController::dispatchMailJob($job->client_id);
    
        $newTimelineEvent = new TimelineEvent;
        $newTimelineEvent->job_id = $job->id;
        $newTimelineEvent->type = "status";
        $newTimelineEvent->data = $job->status;
        $newTimelineEvent->notify_technician = true;
        $newTimelineEvent->notify_client = true;
        $newTimelineEvent->save();
        $newTimelineEvent = TimelineEvent::find($newTimelineEvent->id);
        //All technicians are notified that the job has been assigned
        broadcast(new JobPusherEvent($job, 0))->toOthers();
        $job->timeline = array($newTimelineEvent);
        //The user receives the updated job and it's new timeline (only 1 TimelineEvent)
        broadcast(new JobPusherEvent($job, $job->client_id))->toOthers();
        array_push($jobArray, $job);
      }
    }
    
    foreach ($jobArray as $job){
      $job->files = File::where('job_id', $job->id)->get();
      $job->timeline = TimelineEvent::where('job_id', $job->id)->get();
      $job->messages = []; //A jobs can't have any messages until it is assigned
    }

    return $jobArray;
  }//return : all the jobs that were submitted to assignment, with their full timeline, full files and empty messages arrays

  public function terminate(Request $request)//Called by the client when he terminates a completed job
  {//input : {id: job's id, rating: job's quality rating}
    $job = Job::find($request->id);
    $job->rating = $request->rating;
    $job->save();
    $job->terminated = true;
    $job->delete();
    
    broadcast(new JobPusherEvent($job, $job->technician_id))->toOthers();
    return $job;
  }//return : the job with a "terminated" property set to true*/
}