<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // API Standard function
    public function index()
    {
        return MessageResource::collection(Message::all());
    }

    public function show($id)
    {
        // TODO: validate $id input
        $message = Message::findOrFail($id);
        return new MessageResource($message);
    }

    public function store(StoreMessageRequest $request)
    {
        // TODO: verify if the job exists and is assigned
        $message = Message::create($request->validated());

        // OLD code
        //broadcast(new MessagePusherEvent($newMessage))->toOthers();

        return new MessageResource($message);
    }
}
