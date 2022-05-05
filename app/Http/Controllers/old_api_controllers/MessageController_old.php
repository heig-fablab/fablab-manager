<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Job;
use App\Models\User;
use App\Models\TimelineEvent;
use App\Events\MessagePusherEvent;
use App\Http\Controllers\NotifyEmailController;


class MessageController extends Controller
{
  /*public function store(Request $request)//Called when a new message is added to a conversation
  {//input : {job_id: job's id, text: message's text}
    $job = Job::find($request->job_id);
    $interlocutor = $request->user()->is_technician ? $job->client_id : $job->technician_id;
    $request->user()->is_technician ? $job->notify_client = true : $job->notify_technician = true;
    $job->save();
    NotifyEmailController::dispatchMailJob($interlocutor);

    $newMessage = new Message;
    $newMessage->sender_id = $request->user()->id;
    $newMessage->recipient_id = $interlocutor;
    $newMessage->job_id = $request->job_id;
    $newMessage->text = $request->text;
    $newMessage->save();
    $newMessage = Message::find($newMessage->id);
    
    broadcast(new MessagePusherEvent($newMessage))->toOthers();
    return $newMessage;
  }//return : the new message*/
}