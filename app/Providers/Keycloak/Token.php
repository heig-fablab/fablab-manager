<?php

namespace App\Providers\Keycloak;

use Firebase\JWT\JWT;

/**
 * source: https://github.com/robsontenorio/laravel-keycloak-guard
 * author: Robson Tenório https://github.com/robsontenorio
 * author: adapted by Alec Berney https://github.com/alecberney
 */
class Token
{
    /**
     * Decode a JWT token
     *
     * @param  string  $token
     * @param  string  $publicKey
     * @return mixed|null
     */
    public static function decode(string $token = null, string $publicKey)
    {
        $publicKey = self::buildPublicKey($publicKey);
        return $token ? JWT::decode($token, $publicKey, ['RS256']) : null;
    }

    /**
     * Build a valid public key from a string
     *
     * @param  string  $key
     * @return mixed
     */
    private static function buildPublicKey(string $key)
    {
        return "-----BEGIN PUBLIC KEY-----\n" . wordwrap($key, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
    }
}
