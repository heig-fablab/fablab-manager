<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Job;
use App\Models\User;
use App\Constants\Roles;
use Illuminate\Support\Facades\Log;

class JobPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if (!$user->has_given_role(Roles::CLIENT)) {
            Log::info('JobPolicy: user ' . $user->username . ' is not a client');
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

    public function view(User $user, Job $job)
    {
        return $job->client_username == $user->username
            || $job->worker_username == $user->username
            || $job->validator_username == $user->username;
    }

    public function create(User $user)
    {
        Log::debug('create authorization');
        return true;
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
        return $user->has_given_role(Roles::WORKER);
    }

    public function user_jobs(User $userb)
    {
        return true; // Because client role is already checked
    }

    public function user_as_client_jobs(User $user)
    {
        return true; // Because client role is already checked
    }

    public function user_as_worker_jobs(User $user)
    {
        return $user->has_given_role(Roles::WORKER);
    }

    public function user_as_validator_jobs(User $user)
    {
        return $user->has_given_role(Roles::VALIDATOR);
    }

    public function assign_worker(User $user)
    {
        return $user->has_given_role(Roles::WORKER);
    }

    public function update_status(User $user, Job $job)
    {
        return $user->has_given_role(Roles::WORKER)
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
