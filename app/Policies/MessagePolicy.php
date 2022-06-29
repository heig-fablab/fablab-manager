<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Message;
use App\Models\User;
use App\Models\Job;
use App\Constants\Roles;

class MessagePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->has_given_role(Roles::ADMIN)) {
            return true;
        }

        if (!$user->has_given_role(Roles::CLIENT)) {
            return false;
        }
    }

    // Standard API functions
    public function viewAny(User $user)
    {
        return false; // Because admin role is already checked
    }

    public function view(User $user, int $id)
    {
        $message = Message::findOrFail($id);
        return $message->sender_username == $user->username
            || $message->receiver_username == $user->username;
    }

    public function create(User $user)
    {
        // To verify if user creating the message participate in job given 
        // & if user creating the message is the sender in message given
        $job = Job::findOrFail(app('request')->get('job_id'));
        return $job->participate_in_job($user)
            && $user->username == app('request')->get('sender_username');
    }
}
