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
            Log::Info("Admin user can access jobs route");
            return true;
        }

        if (!$user->has_given_role(Roles::CLIENT)) {
            Log::Warning("An non client user tried to access jobs route");
            return false;
        }
    }

    // Standard API functions
    public function viewAny(User $user)
    {
        Log::Warning("User tried to view all jobs but does not have admin role");
        return false; // Because admin role is already checked
    }

    public function view(User $user, int $id)
    {
        $job = Job::findOrFail($id);

        return PolicyHelper::can_access(
            $job->participate_in_job($user),
            "User can access job with id " . $id,
            "User tried to access job with id " . $id . " but does not participate in it"
        );
    }

    public function create(User $user)
    {
        Log::Info("User can create new job");
        return true;
    }

    public function update(User $user)
    {
        $job = Job::findOrFail(app('request')->get('id'));

        return PolicyHelper::can_access(
            $job->client_username == $user->username,
            "User can update job with id " . $job->id,
            "User tried to update job with id" . $job->id . " but is not client in it"
        );
    }

    public function destroy(User $user, int $id)
    {
        $job = Job::findOrFail($id);

        return PolicyHelper::can_access(
            $job->client_username == $user->username,
            "User can delete job with id " . $id,
            "User tried to delete job with id " . $id . " but is not client in it"
        );
    }

    // Others API functions
    public function unassigned_jobs(User $user)
    {
        return PolicyHelper::can_access(
            $user->has_given_role(Roles::WORKER),
            "User can access unassigned jobs",
            "User tried to access unassigned jobs but is not worker"
        );
    }

    public function user_jobs(User $user, string $username)
    {
        return PolicyHelper::can_access(
            $user->username == $username,
            "User can access user jobs",
            "User tried to access user jobs but is not the user that is being accessed"
        );
    }

    public function user_as_client_jobs(User $user, string $username)
    {
        return PolicyHelper::can_access(
            $user->username == $username,
            "User can access user as client jobs",
            "User tried to access user as client jobs but is not the user that is being accessed"
        );
    }

    public function user_as_worker_jobs(User $user, string $username)
    {
        return PolicyHelper::can_access(
            $user->has_given_role(Roles::WORKER) && $user->username == $username,
            "User can access user as worker jobs",
            "User tried to access user as worker jobs but is not the user
            that is being accessed or is not a worker"
        );
    }

    public function user_as_validator_jobs(User $user, string $username)
    {
        return PolicyHelper::can_access(
            $user->has_given_role(Roles::VALIDATOR) && $user->username == $username,
            "User can access user as validator jobs",
            "User tried to access user as validator jobs but is not the user
            that is being accessed or is not a validator"
        );
    }

    public function assign(User $user)
    {
        return PolicyHelper::can_access(
            $user->has_given_role(Roles::WORKER)
            && app('request')->get('worker_username') == $user->username,
            "User can assign himself job with id " . app('request')->get('id'),
            "User tried to assign himself job with id " . app('request')->get('id')
            . "but is not a worker or is not the worker that is being assigned"
        );
    }

    public function update_status(User $user)
    {
        $job = Job::findOrFail(app('request')->get('id'));

        return PolicyHelper::can_access(
            $user->has_given_role(Roles::WORKER) && $job->worker_username == $user->username,
            "User can update status of job with id " . $job->id,
            "User tried to update status of job with id " . $job->id
            . "but is not a worker or is not the worker of the related job"
        );
    }

    public function update_rating(User $user)
    {
        $job = Job::findOrFail(app('request')->get('id'));

        return PolicyHelper::can_access(
            $job->client_username == $user->username,
            "User can update rating of job with id " . $job->id,
            "User tried to update rating of job with id " . $job->id
            . "but is not the client of the related job"
        );
    }

    public function update_notifications(User $user, int $id, string $username)
    {
        $job = Job::findOrFail($id);

        return PolicyHelper::can_access(
            $job->participate_in_job($user) && $user->username == $username,
            "User can update notifications of job with id " . $job->id,
            "User tried to update notifications of job with id " . $job->id
            . "but is not participating in the related job or is not the user that is being updated"
        );
    }
}
