<?php


namespace AYakovlev\Log;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log
{
    private static Logger $log;

    public static function getLog(): Logger
    {
        self::$log = new Logger('workerReceive');
        self::$log->pushHandler(new StreamHandler(__DIR__ . '/../../logs/workerReceive.log', Logger::INFO));

        return self::$log;
    }
}