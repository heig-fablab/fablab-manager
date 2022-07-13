<?php

namespace App\Providers;

use App\Providers\Keycloak\KeycloakGuard;
use Firebase\JWT\JWT;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

/**
 * source: https://github.com/robsontenorio/laravel-keycloak-guard
 * author: Robson Tenório https://github.com/robsontenorio
 * author: adapted by Alec Berney https://github.com/alecberney
 */
class KeycloakServiceProvider extends ServiceProvider
{
    public function register()
    {
        // https://github.com/auth0/auth0-PHP/issues/56
        // Don't remove, this is for manage clocks differences between servers and machine
        JWT::$leeway = 10;

        // Adding our custom guard
        Auth::extend('keycloak', function ($app, $name, array $config) {
            return new KeycloakGuard(Auth::createUserProvider($config['provider']), $app->request);
        });
    }
}
