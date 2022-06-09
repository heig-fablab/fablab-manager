<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationsEmail;
use App\Models\User;
use App\Models\Event;

class NotificationsEmailJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $backoff = 3;

    public int $unique_id;
    public string $user_switch_uuid;

    public function __construct($id, $user_switch_uuid)
    {
        $this->unique_id = $id;
        $this->user_switch_uuid = $user_switch_uuid;
    }

    public function handle()
    {
        $user = User::find($this->user_switch_uuid);

        // Get all events to notify (unread) that has user give and that are not outdated
        $events = Event::where('user_switch_uuid', $user->switch_uuid)
            ->where('to_notify', true)
            ->where('created_at', '>', $user->last_email_sent)
            ->get();

        if ($events->count() > 0) {
            // Verify for each type of event if we need to send email
            if (($user->require_status_email && $events->contains('type', 'status'))
                || ($user->require_files_email && $events->contains('type', 'file'))
                || ($user->require_messages_email && $events->contains('type', 'message'))
            ) {
                Mail::to($user->email)->send(new NotificationsEmail($user, $events));
            }
        }
    }
}
