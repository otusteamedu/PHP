<?php

namespace App;

use App\Console\Console;

final class App
{
    private static ?Redis $redis = null;

    /**
     * App constructor.
     *
     * @phan-suppress PhanNoopNew
     */
    public function __construct()
    {
        new ErrorHandler();
        if ('cli' === PHP_SAPI) {
            new Console();
        } else {
            Router::dispatch();
        }
    }

    public static function getRedis(): Redis
    {
        if (null === self::$redis) {
            self::$redis = new Redis();
            self::$redis->pconnect(getenv('APP_DSN_REDIS'));
        }
        return self::$redis;
    }

    public static function getEnv(): string
    {
        return getenv('APP_ENV') ?: 'prod';
    }
}
