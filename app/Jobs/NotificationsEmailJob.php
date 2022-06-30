<?php

namespace App\Jobs;

use App\Constants\EventTypes;
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
    public string $user_username;

    public function __construct(int $id, string $user_username)
    {
        $this->unique_id = $id;
        $this->user_username = $user_username;
    }

    public function handle()
    {
        $user = User::find($this->user_username);

        // Get all events to notify (unread) that has user give and that are not outdated
        $events = Event::where('user_username', $user->username)
            ->where('to_notify', true)
            ->where('created_at', '>', $user->last_email_sent)
            ->get();

        if ($events->count() > 0) {
            // Verify for each type of event if we need to send email
            if (($user->require_status_email && $events->contains('type', EventTypes::STATUS))
                || ($user->require_files_email && $events->contains('type', EventTypes::FILE))
                || ($user->require_messages_email && $events->contains('type', EventTypes::MESSAGE))
            ) {
                Mail::to($user->email)->send(new NotificationsEmail($user, $events));
            }
        }
    }
}
