<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Job;

class JobEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // List of job events possible:
    // - job.created -> new job from a client -> to all workers
    // - job.status.assigned -> job assigned to a worker -> to all workers
    // - job.status.updated -> job status changed -> to job client
    // - job.status.terminated -> job terminated -> to job worker

    // TODO: an event by event type?

    public $job;
    //public $id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        // OLD code
        //$this->job = $job;
        //$this->id = $id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
        // OLD code
        //return new Channel('job.channel.' . $this->id);
    }

    /*public function broadcastWith()
    {
        return ['id' => $this->user->id];
    }*/

    /*public function broadcastWhen()
    {
        return $this->order->value > 100;
    }*/
}
