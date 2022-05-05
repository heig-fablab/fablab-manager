<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Models\Job;
use App\Models\TimelineEvent;
use App\Events\JobPusherEvent;
use App\Http\Controllers\NotifyEmailController;


class FileController extends Controller
{
  /*public function store(Request $request)//Called when files are added to an existing job
  {//input : {job_id: job's id, uploaded_files: [the files to be uploaded]}
    $job = Job::find($request->job_id);
    $job->notify_technician = true;
    $job->notify_client = true;
    $job->save();
    $interlocutor = $request->user()->is_technician ? $job->client_id : $job->technician_id;
    NotifyEmailController::dispatchMailJob($interlocutor);
    $addedFiles = Array();
    $addedTimeline = Array();

    foreach($request->uploadedFiles as $file){
      $newFile = new File;
      $newFile->hashed_name = hash_file('sha256', $file);
      $newFile->name = $file->getClientOriginalName();
      $newFile->job_id = $request->job_id;
      $newFile->save();
      $newFile = File::find($newFile->id);
      $addedFiles[] = $newFile;
      $file->storeAs('FileStorage', hash_file('sha256', $file));
      
      $newTimelineEvent = new TimelineEvent;
      $newTimelineEvent->job_id = $newFile->job_id;
      $newTimelineEvent->type = "file";
      $newTimelineEvent->data = $newFile->name;
      $newTimelineEvent->save();
      $newTimelineEvent = TimelineEvent::find($newTimelineEvent->id);
      $addedTimeline[] = $newTimelineEvent;
    }

    $job = Job::find($job->id);
    //The timeline and files must be attached to the job as additional properties
    $job->files = $addedFiles;
    $job->timeline = $addedTimeline;
    broadcast(new JobPusherEvent($job, $interlocutor))->toOthers();
    return $job;
  }//return : the job with it's newly added files and timeline arrays 

  public function download($id)//Self-explanatory
  {//input : {id: file's id}
    $file = File::find($id);
    return Storage::download("FileStorage/$file->hashed_name", $file->name);
  }//return : the requested file*/
}