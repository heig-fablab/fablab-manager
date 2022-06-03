<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyEmail;
use App\Models\Job;
use App\Models\User;
use App\Models\Message;
use App\Models\TimelineEvent;

class NotificationsEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // TODO: https://laravel.com/docs/9.x/queues

    public $backoff = 3;

    // OLD code
    public $userID;
    public $uniqueId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    //OLD code
    public function __construct($id)
    {
        $this->userID = $id;
        $this->uniqueId = $id;
    }

    // TODO: function like this:
    /*public static function dispatchMailJob($id)
    {
        NotifyEmailJob::dispatch($id)->delay(now()->addMinutes(10));
        //NotifyEmailJob::dispatch($id)->delay(now()->addSeconds(30));
    }*/

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // User is notified when he hasn't view his notifications since 10min

        //OLD code
        $user = User::find($this->userID); // get user
        $user_type = $user->is_technician ? 'technician' : 'client'; // gest user type
        $jobs = Job::where($user_type.'_id', $this->userID)
          ->where('notify_'.$user_type, true); // get all jobs with user that need to be email_notified

        // TODO: get all unread events with job and user and that are not outdated, that need to be email_notified

        // where(this->user_switch_uuid, $event->user_switch_uuid)
        // where(this->job_id, $event->job_id)
        // where(this->notified, false)
        // where(this->created_at > $event->user->last_email_sent);

        // if empty, return
        // else prepare events types and send mail with data

        // events_for_user->where('type', 'file')
        // ->count()

        // TODO: if notified -> delete or soft delete
    
        if($jobs->count() > 0)
        {
          $IDs = $jobs->pluck('id'); // get all jobs IDs

          $is_new_status = TimelineEvent::whereIn('job_id', $IDs)
            ->where('type', 'status')
            ->where('notify_'.$user_type, true)
            ->where('created_at', '>', $user->notify_email_updated_at)
            ->count() > 0; // get all events where user need to be email_notified for a status changes
            // and that event has been created after last email notification sent

            // TODO: add ->orderBy('created_at', 'desc')

          $is_new_files = TimelineEvent::whereIn('job_id', $IDs)
            ->where('type', 'file')
            ->where('notify_'.$user_type, true)
            ->where('created_at', '>', $user->notify_email_updated_at)
            ->count() > 0; // same but for files changes

          $is_new_messages = Message::whereIn('job_id', $IDs)
            ->where('recipient_id', $this->userID)
            ->where('notify', true)
            ->where('created_at', '>', $user->notify_email_updated_at)
            ->count() > 0; // get all messages where user need to be email_notified
          
            // TODO: change, don't create event if we doesn't want to be notified
          if($user->notify_email_status && $is_new_status 
              || $user->notify_email_files && $is_new_files 
              || $user->notify_email_messages && $is_new_messages)
          {
            Mail::to($user->email)->send(new NotifyEmail($this->userID));
          }
        }
    }
}
