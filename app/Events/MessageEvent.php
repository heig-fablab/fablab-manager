<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Message;

class MessageEvent implements ShouldBroadcast //ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // List of message events possible:
    // - message.created -> new job from a client -> to all workers

    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('message.'.$this->message->receiver_switch_uuid);
        //return new PrivateChannel('channel-name');
        // OLD code
        //return new Channel('message.channel.'.$this->message->recipient_id);
    }
}
