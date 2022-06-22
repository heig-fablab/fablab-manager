<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\Event;
use App\Models\Job;
use App\Events\MessageCreatedEvent;
use App\Constants\EventTypes;

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

    public function store(StoreMessageRequest $request)
    {
        $req_validated = $request->validated();

        if (Job::findOrFail($request->job_id)->worker_switch_uuid == null) {
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
            'user_switch_uuid' => $message->receiver_switch_uuid,
            'job_id' => $message->job_id
        ]);

        // Emails
        Event::create_mail_job($message->receiver_switch_uuid);

        return new MessageResource($message);
    }
}
