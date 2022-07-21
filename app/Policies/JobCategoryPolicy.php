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
            Log::Info("Admin user can access job categories route");
            return true;
        }

        if (!$user->has_given_role(Roles::CLIENT)) {
            Log::Warning("An non client user tried to access job categories route");
            return false;
        }
    }

    // Standard API functions
    public function viewAny(User $user)
    {
        Log::Info("User can access list of job categories");
        return true; // Because user role is already checked
    }

    public function view(User $user, int $id)
    {
        Log::Info("User can access job category with id " . $id);
        return true; // Because user role is already checked
    }

    public function create(User $user)
    {
        Log::Warning("User tried to create job category but does not have admin role");
        return false; // Because admin role is already checked
    }

    public function update(User $user)
    {
        Log::Warning("User tried to update job category with id"
            . app('request')->get('id') . " but does not have admin role");
        return false; // Because admin role is already checked
    }

    public function destroy(User $user, int $id)
    {
        Log::Warning("User tried to delete job category with id" . $id . " but does not have admin role");
        return false; // Because admin role is already checked
    }

    // Others API functions
    public function image(User $user, int $id)
    {
        Log::Info("User can access job category image with id " . $id);
        return true; // Because user role is already checked
    }
}
