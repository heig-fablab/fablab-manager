<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Message;
use App\Models\User;
use App\Constants\Roles;

class MessagePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if (!$user->has_given_role($user, Roles::CLIENT)) {
            return false;
        }

        if ($user->has_given_role($user, Roles::ADMIN)) {
            return true;
        }
    }

    // Standard API functions
    public function viewAny(User $user)
    {
        return false; // Because admin role is already checked
    }

    public function view(User $user, Message $message)
    {
        return $message->sender_username == $user->username
            || $message->receiver_username == $user->username;
    }

    public function create(User $user)
    {
        return true; // Because client role is already checked
    }
}
