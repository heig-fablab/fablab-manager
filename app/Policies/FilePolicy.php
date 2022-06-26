<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\File;
use App\Models\User;
use App\Constants\Roles;

class FilePolicy
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
    public function view(User $user, File $file)
    {
        return $file->job->client_username == $user->username
            || $file->job->worker_username == $user->username
            || $file->job->validator_username == $user->username;
    }

    public function create(User $user)
    {
        return true; // Because client role is already checked
    }

    public function update(User $user, File $file)
    {
        return $file->job->client_username == $user->username;
    }

    public function delete(User $user, File $file)
    {
        return $file->job->client_username == $user->username;
    }
}
