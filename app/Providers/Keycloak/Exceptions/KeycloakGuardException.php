<?php

namespace App\Providers\Keycloak\Exceptions;

/**
 * source: https://github.com/robsontenorio/laravel-keycloak-guard
 * author: Robson Tenório https://github.com/robsontenorio
 * author: adapted by Alec Berney https://github.com/alecberney
 */
class KeycloakGuardException extends \UnexpectedValueException
{
    public function __construct(string $message)
    {
        $this->message = "[Keycloak Guard] {$message}";
    }
}
