<?php

namespace App\Constants;

final class JobStatus
{
    public const NEW = 'new';
    public const VALIDATED = 'validated';
    public const ASSIGNED = 'assigned';
    public const ONGOING = 'ongoing';
    public const ON_HOLD = 'on-hold';
    public const COMPLETED = 'completed';
    public const CLOSED = 'closed';

    public const AllJobStatus = [
        self::NEW,
        self::VALIDATED,
        self::ASSIGNED,
        self::ONGOING,
        self::ON_HOLD,
        self::COMPLETED,
        self::CLOSED
    ];
}


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
