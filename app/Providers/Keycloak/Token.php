<?php

namespace App\Providers\Keycloak;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * source: https://github.com/robsontenorio/laravel-keycloak-guard
 * author: Robson Tenório https://github.com/robsontenorio
 * author: adapted by Alec Berney https://github.com/alecberney
 */
class Token
{
    const JWT_ALGORITHM = 'RS256';
    const BEGIN_KEY_TEXT = "-----BEGIN PUBLIC KEY-----\n";
    const END_KEY_TEXT = "\n-----END PUBLIC KEY-----";

    /**
     * Decode a JWT token
     *
     * @param  string  $token
     * @param  string  $publicKey
     * @return mixed|null
     */
    public static function decode(string $publicKey, string $token = null)
    {
        $publicKey = self::buildPublicKey($publicKey);
        return $token ? JWT::decode($token, new Key($publicKey, self::JWT_ALGORITHM)) : null;
    }

    /**
     * Build a valid public key from a string
     *
     * @param  string  $key
     * @return mixed
     */
    private static function buildPublicKey(string $key)
    {
        return self::BEGIN_KEY_TEXT
            . wordwrap($key, 64, "\n", true)
            . self::END_KEY_TEXT;
    }
}
