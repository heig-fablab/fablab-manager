<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\FileType;
use App\Models\User;
use App\Constants\Roles;

class FileTypePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->has_given_role(Roles::ADMIN);
    }
}
