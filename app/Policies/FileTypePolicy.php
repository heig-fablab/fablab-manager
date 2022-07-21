<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Constants\Roles;

class FileTypePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return PolicyHelper::can_access(
            $user->has_given_role(Roles::ADMIN),
            "User can access file types route",
            "User cannot access file types route");
    }
}
