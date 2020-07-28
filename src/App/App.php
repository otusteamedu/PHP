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
    public static $db = null;
    /**
     * @var Queue
     */
    public static $queue = null;
    /**
     * @var Client
     */
    public static $user = null;


    public function __construct()
    {
        self::getDb();
        self::getQueue();
        self::getUser();
        Route::dispatch();
    }

    public function getQueue(): Queue
    {
        self::$queue = (new RedisQueue())->connect();
        return self::$queue;
    }

    public function getDb(): Db
    {
        self::$db = (new DbMySQL())->connect();
        return self::$db;
    }

    public function getUser(): ?Client
    {
        if (php_sapi_name() == 'cli')
            return null;

        self::$user = Authentication::check();
        return self::$user;
    }
}
