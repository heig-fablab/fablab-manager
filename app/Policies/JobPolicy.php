<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Job;
use App\Models\User;
use App\Constants\Roles;

class JobPolicy
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

    public function view(User $user, Job $job)
    {
        return $job->client_username == $user->username
            || $job->worker_username == $user->username
            || $job->validator_username == $user->username;
    }

    public function create(User $user)
    {
        return $user->has_given_role($user, Roles::CLIENT);
    }

    public function update(User $user, Job $job)
    {
        return $job->client_username == $user->username;
    }

    public function delete(User $user, Job $job)
    {
        return $job->client_username == $user->username;
    }

    // Others API functions
    public function unassigned_jobs(User $user)
    {
        return $user->has_given_role($user, Roles::WORKER);
    }

    public function user_jobs(User $userb)
    {
        return true;
    }

    public function user_as_client_jobs(User $user)
    {
        return true;
    }

    public function user_as_worker_jobs(User $user)
    {
        return $user->has_given_role($user, Roles::WORKER);
    }

    public function user_as_validator_jobs(User $user)
    {
        return $user->has_given_role($user, Roles::VALIDATOR);
    }

    public function assign_worker(User $user)
    {
        return $user->has_given_role($user, Roles::WORKER);
    }

    public function update_status(User $user, Job $job)
    {
        return $user->has_given_role($user, Roles::WORKER)
            || $job->worker_username == $user->username;
    }

    public function update_rating(User $user, Job $job)
    {
        return $job->client_username == $user->username;
    }

    public function update_notifications(User $user, Job $job)
    {
        return $job->client_username == $user->username
            || $job->worker_username == $user->username
            || $job->validator_username == $user->username;
    }
}
