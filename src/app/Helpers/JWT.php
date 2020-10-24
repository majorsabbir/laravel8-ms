<?php

namespace App\Helpers;

use \Firebase\JWT\JWT as FJWT;

class JWT
{
    protected static $algorithms = ['HS256', 'HS384', 'HS512'];

    public static function getPayload($token)
    {
        try {
            return FJWT::decode($token, config('auth.secret_token'), self::$algorithms);
        } catch (\Firebase\JWT\ExpiredException $e) {
            throw new \Illuminate\Auth\AuthenticationException($e->getMessage());
        } catch (\UnexpectedValueException $e) {
            throw new \Illuminate\Auth\AuthenticationException('Unauthenticated');
        }
    }
}
