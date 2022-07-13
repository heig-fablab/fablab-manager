<?php

namespace App\Providers\Keycloak;

use App\Models\User;
use App\Providers\Keycloak\Exceptions\TokenException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * source: https://github.com/robsontenorio/laravel-keycloak-guard
 * author: Robson Tenório https://github.com/robsontenorio
 * author: adapted by Alec Berney https://github.com/alecberney
 */
class KeycloakGuard implements Guard
{
    private $config;
    private $user;
    private $provider;
    private $decodedToken;

    public function __construct(UserProvider $provider, Request $request)
    {
        $this->config = config('keycloak');
        $this->user = null;
        $this->provider = $provider;
        $this->decodedToken = null;
        $this->request = $request;

        $this->authenticate();
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check(): bool
    {
        return !is_null($this->user());
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest(): bool
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (is_null($this->user)) {
            return null;
        }

        return $this->user;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        if ($user = $this->user()) {
            return $this->user()->id;
        }
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = []): bool
    {
        if (!$this->decodedToken) {
            return false;
        }

        // Load user from BD
        $user = $this->provider->retrieveByCredentials($credentials);

        if (!$user) {
            // Create user in BD if not exists
            log::Info("User not found. create a new one with credentials: " . json_encode($credentials));
            User::create([
                'username' => $this->decodedToken['preferred_username'],
                'name' => $this->decodedToken['given_name'],
                'surname' => $this->decodedToken['family_name'],
                'email' => $this->decodedToken['email'],
            ]);
        }

        $this->setUser($user);

        return true;
    }

    /**
     * Determine if the guard has a user instance.
     *
     * @return bool
     */
    public function hasUser(): bool
    {
        return !is_null($this->user());
    }

    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }

    /**
     * Returns full decoded JWT token from athenticated user
     *
     * @return mixed|null
     */
    public function token()
    {
        return json_encode($this->decodedToken);
    }

    /**
     * Decode token, validate and authenticate user
     *
     * @return mixed
     */
    private function authenticate()
    {
        try {
            $this->decodedToken = Token::decode($this->config['realm_public_key'], $this->request->bearerToken());
        } catch (\Exception $e) {
            throw new TokenException($e->getMessage());
        }

        if ($this->decodedToken) {
            $this->validate([
                $this->config['user_provider_credential'] => $this->decodedToken->{$this->config['token_principal_attribute']}
            ]);
        }
    }
}
