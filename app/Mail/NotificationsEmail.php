<?php

namespace App\Mail;

//use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Job;
use App\Models\User;
use App\Models\File;
use App\Models\Event;

class NotificationsEmail extends Mailable
{
    //use Queueable, SerializesModels;
    use SerializesModels;

    // TODO: Adapt
    // https://laravel.com/docs/9.x/mail

    public $events;
    public $jobs;
    public $user;

    // OLD code
    // Can be used in blade template
    /*public $jobs;
    public $userID;*/

    // TODO: change to get job category
    /*public $jobTypeTextFormatter = array(
        "cutting"=>"de découpage laser", 
        "milling"=>"de fraisage CNC", 
        "3Dprinting"=>"d'impression 3D", 
        "engraving"=>"de gravure laser");*/

    public $job_status_formatter = array(
        "new"=>array("name"=>"Nouveau", "color"=>"#E0E0E0"),
        "validated"=>array("name"=>"VALIDÉ", "color"=>"#B3E5FC"),
        "assigned"=>array("name"=>"ASSIGNÉ", "color"=>"#B3E5FC"),
        "ongoing"=>array("name"=>"EN COURS", "color"=>"#03A9F4"),
        "on-hold"=>array("name"=>"EN PAUSE", "color"=>"#F44336"),
        "completed"=>array("name"=>"TERMINÉ", "color"=>"#4CAF50"),
        "closed"=>array("name"=>"FERMÉ", "color"=>"#4CAF50"));

    // TODO: recieve values already calculated in job
    // Events are already filtered, only events that need to be notified are passed
    public function __construct(User $user, array $events)
    {
        // OLD code
        //$this->userID = $id;
        //$this->subject("Notifications pour vos travaux");

        $this->subject("Notifications pour vos travaux");
        $this->user = $user;
        $this->events = $events;
    }

    public function build()
    {
        /*return $this->from('fablab@heig-vd.ch', 'Fablab Manager')
                    ->subject('Notifications')
                    ->view('emails.notifications');*/

        // Get all jobs that need to be email_notified
        $this->jobs = Job::whereIn('id', $this->events->pluck('job_id'))->get();

        // For each job, set up all the data needed to be displayed in the email
        foreach($this->jobs as $job) {
            $job->new_status_event = null;
            $job->new_files_count = 0;
            $job->new_messages_count = 0;

            if ($user->require_status_email) {
                $job->new_status_event = $this->events->sortDesc('created_at')
                    ->filter('job_id', $job->id)
                    ->filter('type', 'status')
                    ->first();
            }
            if ($user->require_files_email) {
                $job->new_files_count = $this->events->filter('job_id', $job->id)
                    ->filter('type', 'file')
                    ->count();
            }
            if ($user->require_messages_email) {
                $job->new_messages_count = $this->events->filter('job_id', $job->id)
                    ->filter('type', 'message')
                    ->count();
            }

            $job->interlocutor = $this->user;
        }
        return $this->view('mails/email');
    }
}
