<?php
namespace EmailValidator\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class AppLogger
{

    public static function addLog(int $ERROR, string $message)
    {
        $log = new Logger('app');
        $log->pushHandler(new StreamHandler($_ENV['LOG_PATH']));
        $log->addRecord($level, $message, $context);
    }
}