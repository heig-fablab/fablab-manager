<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Constants\Roles;
use Illuminate\Support\Facades\Log;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->has_given_role(Roles::ADMIN)) {
            Log::Info("Admin user can access users route");
            return true;
        }

        if (!$user->has_given_role(Roles::CLIENT)) {
            Log::Warning("An non client user tried to access users route");
            return false;
        }
    }

    // Standard API functions
    public function viewAny(User $user)
    {
        Log::Warning("User tried to view all users but does not have admin role");
        return false; // Because admin role is already checked
    }

    public function view(User $user, string $username)
    {
        return PolicyHelper::can_access(
            $username == $user->username,
            "User can access user with username " . $username,
            "User tried to access user with username " . $username . "but is not user corresponding"
        );
    }

    //public function create(?User $user)
    public function create(User $user)
    {
        //return optional($user)->id === $post->user_id;
        Log::Warning("User tried to create user but does not have admin role");
        return false; // Because admin role is already checked
    }

    public function update(User $user)
    {
        /*$model = User::findOrFail(app('request')->get('username'));
        return $user->username === $model->username;*/
        Log::Warning("User tried to update user but does not have admin role");
        return false; // Because admin role is already checked
    }

    public function destroy(User $user, string $username)
    {
        Log::Warning("User tried to delete user but does not have admin role");
        return false; // Because admin role is already checked
    }

    // Others API functions
    public function update_email_notifications(User $user)
    {
        return PolicyHelper::can_access(
            $user->username == app('request')->get('username'),
            "User can update email notifications settings of user with username "
            . app('request')->get('username'),
            "User tried to update email notifications settings of user with username "
            . app('request')->get('username') . "but is not user corresponding"
        );
    }
}
