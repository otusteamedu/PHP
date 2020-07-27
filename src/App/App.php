<?php

namespace Ozycast\App;

use Ozycast\App\Core\Route;
use Ozycast\App\Core\Db;
use Ozycast\App\Core\DbMySQL;
use Ozycast\App\Core\Queue;
use Ozycast\App\Core\RedisQueue;

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

    public function __construct()
    {
        self::getDb();
        self::getQueue();
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
}
