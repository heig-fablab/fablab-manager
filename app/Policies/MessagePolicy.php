<?php

namespace App\Policies;

use App\Constants\Roles;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Message;
use App\Models\User;
use App\Models\Job;
use Illuminate\Support\Facades\Log;

class MessagePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->has_given_role(Roles::ADMIN)) {
            Log::Info("Admin user can access messages route");
            return true;
        }

        if (!$user->has_given_role(Roles::CLIENT)) {
            Log::Warning("An non client user tried to access messages route");
            return false;
        }
    }

    // Standard API functions
    public function viewAny(User $user)
    {
        Log::Warning("User tried to view all messages but does not have admin role");
        return false; // Because admin role is already checked
    }

    public function view(User $user, int $id)
    {
        $message = Message::findOrFail($id);

        return PolicyHelper::can_access(
            $message->participate_in_message($user),
            "User can access message with id " . $id,
            "User tried to access message with id " . $id . "but does not participate in message related"
        );
    }

    public function create(User $user)
    {
        // To verify if user creating the message participate in job given
        // & if user creating the message is the sender in message given
        $job = Job::findOrFail(app('request')->get('job_id'));

        return PolicyHelper::can_access(
            $job->participate_in_job($user) && $user->username == app('request')->get('sender_username'),
            "User can create message",
            "User tried to create message but does not participate in job related with id "
            . $job->id . " or is not sender in message"
        );
    }
}
