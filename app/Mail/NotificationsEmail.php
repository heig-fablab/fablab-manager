<?php

namespace App\Mail;

//use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Job;
use App\Models\User;
use App\Models\File;
use App\Models\TimelineEvent;
use App\Models\Message;

class NotificationsEmail extends Mailable
{
    //use Queueable, SerializesModels;
    use SerializesModels;

    // TODO: Adapt
    // https://laravel.com/docs/9.x/mail

    public $events;
    public $jobs;
    public $user_switch_uuid;

    // OLD code
    // Can be used in blade template
    /*public $jobs;
    public $userID;
    public $jobTypeTextFormatter = array("cutting"=>"de découpage laser", "milling"=>"de fraisage CNC", "3Dprinting"=>"d'impression 3D", "engraving"=>"de gravure laser");
    public $jobStatusFormatter = array(
      "new"=>array("name"=>"Nouveau", "color"=>"#E0E0E0"),
      "assigned"=>array("name"=>"ASSIGNÉ", "color"=>"#B3E5FC"),
      "ongoing"=>array("name"=>"EN COURS", "color"=>"#03A9F4"),
      "on-hold"=>array("name"=>"EN PAUSE", "color"=>"#F44336"),
      "completed"=>array("name"=>"TERMINÉ", "color"=>"#4CAF50"));*/

    // TODO: recieve values already calculated in job
    public function __construct(string $user_switch_uuid, array $events)
    {
        // OLD code
        //$this->userID = $id;
        //$this->subject("Notifications pour vos travaux");

        $this->events = $events;
        $this->user_switch_uuid = $user_switch_uuid;
    }

    public function build()
    {
        /*return $this->from('fablab@heig-vd.ch', 'Fablab Manager')
                    ->subject('Notifications')
                    ->view('emails.notifications');*/

        // TODO: user array_filter($array1, "odd")
        //https://www.php.net/manual/fr/function.array-filter.php

        // OLD code
        $user = User::find($this->userID);
        $user_type = $user->is_technician ? 'technician' : 'client';

        $this->jobs = Job::where($user_type.'_id', $this->userID)
            ->where('notify_'.$user_type, true)
            ->get();

        foreach($this->jobs as $job){
            $job->new_status_event = TimelineEvent::where('job_id', $job->id)
                ->where('type', 'status')
                ->where('notify_'.$user_type, true)
                ->orderBy('created_at', 'desc')
                ->first();

            $job->new_files_count = TimelineEvent::where('job_id', $job->id)
                ->where('type', 'file')
                ->where('notify_'.$user_type, true)
                ->count();

            $job->new_messages_count = Message::where('job_id', $job->id)
                ->where('recipient_id', $this->userID)
                ->where('notify', true)
                ->count();

            $job->interlocutor = $user->is_technician ? User::find($job->client_id) : User::find($job->technician_id);
        }

        return $this->view('mails/email');
    }
}
