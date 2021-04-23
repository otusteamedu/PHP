<?php
namespace VideoPlatform\loggers;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class AppLogger
{
    public static function addLog($level, string $message, array $context = [])
    {
        $log = new Logger('app');
        $log->pushHandler(new StreamHandler($_ENV['LOG_FILE_PATH']));
        $log->addRecord($level, $message, $context);
    }
}