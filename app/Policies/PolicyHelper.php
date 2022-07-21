<?php

namespace App\Policies;

use Illuminate\Support\Facades\Log;

class PolicyHelper
{
    public static function can_access(bool $result, string $ok_message, string $error_message): bool
    {
        if (!$result) {
            Log::Warning($error_message);
        } else {
            Log::Info($ok_message);
        }
        return $result;
    }
}
