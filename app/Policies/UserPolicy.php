<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Constants\Roles;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if (!$user->has_given_role(Roles::CLIENT)) {
            return false;
        }

        if ($user->has_given_role(Roles::ADMIN)) {
            return true;
        }
    }

    // Standard API functions
    public function viewAny(User $user)
    {
        return false; // Because admin role is already checked
    }

    public function view(User $user, string $username)
    {
        return $username == $user->username;
    }

    //public function create(?User $user)
    public function create(User $user)
    {
        //return optional($user)->id === $post->user_id;
        return false; // Because admin role is already checked
    }

    public function update(User $user)
    {
        /*$model = User::findOrFail(app('request')->get('username'));
        return $user->username === $model->username;*/
        return false; // Because admin role is already checked
    }

    public function destroy(User $user, string $username)
    {
        return false; // Because admin role is already checked
    }

    // Others API functions
    public function update_email_notifications(User $user)
    {
        return true; // Because client role is already checked
    }
}
