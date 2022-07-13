<?php

namespace App\Providers;

use App\Providers\Keycloak\KeycloakGuard;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

/**
 * source: https://github.com/robsontenorio/laravel-keycloak-guard
 */
class KeycloakServiceProvider extends ServiceProvider
{
    public function register()
    {
        Auth::extend('keycloak', function ($app, $name, array $config) {
            return new KeycloakGuard(Auth::createUserProvider($config['provider']), $app->request);
        });
    }

    public function boot()
    {
        // Already published by my own

        /*$this->publishes([
            __DIR__ . '/../config/keycloak.php' => app()->configPath('keycloak.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/../config/keycloak.php', 'keycloak');*/
    }
}
