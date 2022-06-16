<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Job;
use App\Models\User;

class NotificationsEmail extends Mailable
{
    use SerializesModels;

    public object $events;
    public object $jobs;
    public User $user;

    public static $job_status_formatter = array(
        "new" => array("name" => "Nouveau", "color" => "#E0E0E0"),
        "validated" => array("name" => "VALIDÉ", "color" => "#B3E5FC"),
        "assigned" => array("name" => "ASSIGNÉ", "color" => "#B3E5FC"),
        "ongoing" => array("name" => "EN COURS", "color" => "#03A9F4"),
        "on-hold" => array("name" => "EN PAUSE", "color" => "#F44336"),
        "completed" => array("name" => "TERMINÉ", "color" => "#4CAF50"),
        "closed" => array("name" => "FERMÉ", "color" => "#4CAF50")
    );

    // Events are already filtered, only events that need to be notified are passed
    public function __construct(User $user, object $events)
    {
        $this->user = $user;
        $this->events = $events;
        $this->subject("Notifications pour vos travaux");
    }

    public function build()
    {
        // Get all jobs that need to be email_notified
        $this->jobs = Job::whereIn('id', $this->events->pluck('job_id'))->get();

        // For each job, set up all the data needed to be displayed in the email
        foreach ($this->jobs as $job) {
            $job->new_status_event = null;
            $job->new_files_count = 0;
            $job->new_messages_count = 0;

            if ($this->user->require_status_email) {
                $job->new_status_event = $this->get_newest_status_event_job($job);
            }
            if ($this->user->require_files_email) {
                $job->new_files_count = $this->count_new_files_events_job($job);
            }
            if ($this->user->require_messages_email) {
                $job->new_messages_count = $this->count_new_messages_events_job($job);
            }

            $job->interlocutor = $this->user;
        }
        // Update the user's last email fields
        $this->user->last_email_sent = now();
        $this->user->save();

        return $this->view('mails/email');
    }

    private function get_newest_status_event_job(Job $job)
    {
        return $this->events
            ->filter(function ($value, $key) use ($job) {
                return $value->job_id == $job->id && $value->type == 'status';
            })
            ->sortByDesc(function ($event) {
                return $event->created_at;
            })
            ->values()
            ->first();
    }

    private function count_new_files_events_job(Job $job)
    {
        return $this->events
            ->filter(function ($value, $key) use ($job) {
                return $value->job_id == $job->id && $value->type == 'files';
            })
            ->count();
    }

    private function count_new_messages_events_job(Job $job)
    {
        return $this->events
            ->filter(function ($value, $key) use ($job) {
                return $value->job_id == $job->id && $value->type == 'messages';
            })
            ->count();
    }
}
