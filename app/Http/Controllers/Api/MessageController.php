<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\Event;
use App\Events\MessageCreatedEvent;

class MessageController extends Controller
{
    // API Standard function
    public function index()
    {
        return MessageResource::collection(Message::all());
    }

    public function show(int $id)
    {
        // TODO: validate $id input
        $message = Message::findOrFail($id);
        return new MessageResource($message);
    }

    public function store(StoreMessageRequest $request)
    {
        // TODO: verify if the job exists and is assigned
        $message = Message::create($request->validated());

        // Notifications
        broadcast(new MessageCreatedEvent($message)); //->toOthers();

        // Create and save Event (notify receiver)
        Event::create([
            'type' => Event::T_MESSAGE,
            'to_notify' => true,
            'user_switch_uuid' => $message->receiver_switch_uuid,
            'job_id' => $message->job_id
        ]);

        // Emails
        Event::create_mail_job($message->receiver_switch_uuid);

        return new MessageResource($message);
    }
}
