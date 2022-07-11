<?php

namespace App\Http\Controllers\Api;

use App\Constants\EventTypes;
use App\Events\MessageCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Event;
use App\Models\Job;
use App\Models\Message;

class MessageController extends Controller
{
    // API Standard function
    public function index()
    {
        return MessageResource::collection(Message::all());
    }

    public function show(int $id)
    {
        $message = Message::findOrFail($id);
        return new MessageResource($message);
    }

    public function store(MessageRequest $request)
    {
        $req_validated = $request->validated();

        if (Job::findOrFail($request->job_id)->worker_username == null) {
            return response()->json([
                'message' => "You can't create a message related to a job who hasn't a worker defined!"
            ], 400);
        }

        $message = Message::create($req_validated);

        // Notifications
        broadcast(new MessageCreatedEvent($message)); //->toOthers();

        // Create and save Event (notify receiver)
        Event::create([
            'type' => EventTypes::MESSAGE,
            'to_notify' => true,
            'user_username' => $message->receiver_username,
            'job_id' => $message->job_id
        ]);

        // Emails
        Event::create_mail_job($message->receiver_username);

        return new MessageResource($message);
    }
}
