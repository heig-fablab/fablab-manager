<?php

namespace App\Providers;

use App\Providers\Keycloak\KeycloakGuard;
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
        // Adding our custom guard
        Auth::extend('keycloak', function ($app, $name, array $config) {
            return new KeycloakGuard(Auth::createUserProvider($config['provider']), $app->request);
        });
    }
}
