<?php

namespace App\Constants;

final class Roles
{
    public const ADMIN = 'admin';
    public const CLIENT = 'client';
    public const WORKER = 'worker';
    public const VALIDATOR = 'validator';

    public const AllRoles = [
        self::ADMIN,
        self::CLIENT,
        self::WORKER,
        self::VALIDATOR
    ];
}
