<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Constants\Roles;
use Illuminate\Support\Facades\Log;

class JobCategoryPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->has_given_role(Roles::ADMIN)) {
            return true;
        }

        if (!$user->has_given_role(Roles::CLIENT)) {
            Log::info('JobPolicy: user ' . $user->username . ' is not a client');
            return false;
        }
    }

    // Standard API functions
    public function viewAny(User $user)
    {
        return true; // Because user role is already checked
    }

    public function view(User $user)
    {
        return true; // Because user role is already checked
    }

    public function create(User $user)
    {
        return false; // Because admin role is already checked
    }

    public function update(User $user)
    {
        return false; // Because admin role is already checked
    }

    public function destroy(User $user)
    {
        return false; // Because admin role is already checked
    }

    // Others API functions
    public function image(User $user)
    {
        return true; // Because user role is already checked
    }
}
