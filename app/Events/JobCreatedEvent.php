<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Job;

class JobCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Job $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function broadcastOn(): Channel
    {
        // TODO: perhaps not doing a chan but construct a chan per worker
        //return new Channel('job.workers.'.$this->job->worker_switch_uuid);
        return new PrivateChannel('job.workers');
    }
}
