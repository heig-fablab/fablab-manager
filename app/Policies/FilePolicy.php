<?php

namespace App\Policies;

use App\Constants\Roles;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\File;
use App\Models\User;
use App\Models\Job;
use Illuminate\Support\Facades\Log;

class FilePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->has_given_role(Roles::ADMIN)) {
            Log::Info("Admin user can access files route");
            return true;
        }

        if (!$user->has_given_role(Roles::CLIENT)) {
            Log::Warning("An non client user tried to access files route");
            return false;
        }
    }

    // Standard API functions
    public function view(User $user, int $id)
    {
        $file = File::findOrFail($id);

        return PolicyHelper::can_access(
            $file->job->participate_in_job($user),
            "User can access file with id " . $id,
            "User tried to access file with id " . $id . "but does not participate in job related"
        );
    }

    public function create(User $user)
    {
        // Verify if user uploading file is client in job given
        $job = Job::findOrFail(app('request')->get('job_id'));

        return PolicyHelper::can_access(
            $job->client_username == $user->username,
        "User can add new file",
        "User tried to add file to a job but is not client in job related"
        );
    }

    public function update(User $user)
    {
        $file = File::findOrFail(app('request')->get('id'));

        return PolicyHelper::can_access(
            $file->job->client_username == $user->username,
            "User can update file with id " . $file->id,
            "User tried to update file with id ". $file->id . " to a job but is not client in job related"
        );
    }

    public function destroy(User $user, int $id)
    {
        $file = File::findOrFail($id);

        return PolicyHelper::can_access(
            $file->job->client_username == $user->username,
            "User can delete file with id " . $id,
            "User tried to delete file with id " . $id . " to a job but is not client in job related"
        );
    }

    // Other functions
    public function download(User $user, int $id)
    {
        $file = File::findOrFail($id);

        if ($file->job == null && $file->job_category != null) {
            Log::Info("User can download file with id " . $id);
            return true;
        }

        return PolicyHelper::can_access(
            $file->job->participate_in_job($user),
            "User can download file with id " . $id,
            "User tried to download file with id " . $id . " but does not participate in job related"
        );
    }
}
