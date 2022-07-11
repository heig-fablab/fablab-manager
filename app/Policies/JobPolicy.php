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
        return false; // Because admin role is already checked
    }

    public function view(User $user, int $id)
    {
        $job = Job::findOrFail($id);
        return $job->participate_in_job($user);
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user)
    {
        $job = Job::findOrFail(app('request')->get('id'));
        return $job->client_username == $user->username;
    }

    public function destroy(User $user, int $id)
    {
        $job = Job::findOrFail($id);
        return $job->client_username == $user->username;
    }

    // Others API functions
    public function unassigned_jobs(User $user)
    {
        return $user->has_given_role(Roles::WORKER);
    }

    public function user_jobs(User $user, string $username)
    {
        return $user->username == $username;
    }

    public function user_as_client_jobs(User $user, string $username)
    {
        return $user->username == $username;
    }

    public function user_as_worker_jobs(User $user, string $username)
    {
        return $user->has_given_role(Roles::WORKER)
            && $user->username == $username;
    }

    public function user_as_validator_jobs(User $user, string $username)
    {
        return $user->has_given_role(Roles::VALIDATOR)
            && $user->username == $username;
    }

    public function assign(User $user)
    {
        return $user->has_given_role(Roles::WORKER)
            && app('request')->get('worker_username') == $user->username;
    }

    public function update_status(User $user)
    {
        $job = Job::findOrFail(app('request')->get('id'));
        return $user->has_given_role(Roles::WORKER)
            && $job->worker_username == $user->username;
    }

    public function update_rating(User $user)
    {
        $job = Job::findOrFail(app('request')->get('id'));
        return $job->client_username == $user->username;
    }

    public function update_notifications(User $user, int $id, string $username)
    {
        $job = Job::findOrFail($id);
        return $job->participate_in_job($user)
            && $user->username == $username;
    }
}
