<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\File;
use App\Models\User;
use App\Models\Job;
use App\Constants\Roles;

class FilePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->has_given_role(Roles::ADMIN)) {
            return true;
        }

        if (!$user->has_given_role(Roles::CLIENT)) {
            return false;
        }
    }

    // Standard API functions
    public function view(User $user, int $id)
    {
        $file = File::findOrFail($id);
        return $file->job->participate_in_job($user);
    }

    public function create(User $user)
    {
        // Verify if user uploading file is client in job given
        $job = Job::findOrFail(app('request')->get('job_id'));
        return $job->client_username == $user->username;
    }

    public function update(User $user)
    {
        $file = File::findOrFail(app('request')->get('id'));
        return $file->job->client_username == $user->username;
    }

    public function destroy(User $user, int $id)
    {
        $file = File::findOrFail($id);
        return $file->job->client_username == $user->username;
    }
}
