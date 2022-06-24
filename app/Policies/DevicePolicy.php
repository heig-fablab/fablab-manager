<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Device;
use App\Models\User;
use App\Constants\Roles;

class DevicePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->has_given_role($user, Roles::ADMIN);
    }
}
