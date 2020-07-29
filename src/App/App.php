<?php

namespace Ozycast\App;

use Ozycast\App\Core\Authentication;
use Ozycast\App\Core\Route;
use Ozycast\App\Core\Db;
use Ozycast\App\Core\DbMySQL;
use Ozycast\App\Core\Queue;
use Ozycast\App\Core\RedisQueue;
use Ozycast\App\DTO\Client;

Class App
{
    /**
     * @var Db
     */
    private static $db = null;
    /**
     * @var Queue
     */
    private static $queue = null;
    /**
     * @var Client
     */
    private static $user = null;


    public function __construct()
    {
        Route::dispatch();
    }

    public static function getQueue(): Queue
    {
        if (!self::$queue) {
            self::$queue = (new RedisQueue())->connect();
        }
        return self::$queue;
    }

    public static function getDb(): Db
    {
        if (!self::$db) {
            self::$db = (new DbMySQL())->connect();
        }
        return self::$db;
    }

    public static function getUser(): ?Client
    {
        if (php_sapi_name() == 'cli') {
            return null;
        }

        if (!self::$user) {
            self::$user = Authentication::check();
        }
        return self::$user;
    }
}
