<?php

namespace App\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class AppLogger
{
    public static function addLog(int $level, string $message, $context = []): void
    {
        $log = new Logger('app');
        $log->pushHandler(new StreamHandler($_ENV['LOG_PATH']));
        $log->addRecord($level, $message, $context);
    }
}