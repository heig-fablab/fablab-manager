<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Job;

class JobCreatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $job;

    public function __construct()
    {
        $this->job = $job;
    }

    public function broadcastOn()
    {
        // TODO: perhaps not doing a chan but construct a chan per worker
        return new Channel('job.workers.'.$this->job->worker_switch_uuid);
    }
}
