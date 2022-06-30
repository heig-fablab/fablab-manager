<?php

namespace App\Constants;

final class EventTypes
{
    public const MESSAGE = 'message';
    public const FILE = 'file';
    public const STATUS = 'status';

    public const AllEventTypes = [
        self::MESSAGE,
        self::FILE,
        self::STATUS
    ];
}
