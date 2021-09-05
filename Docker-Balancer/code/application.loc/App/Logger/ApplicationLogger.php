<?php

namespace App\Logger;


use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\HtmlFormatter;


class ApplicationLogger
{
    const APP_LOG_PATH = 'log/application.log';

    /**
     * Добавляет запись в log-файл
     *
     * @param int $level
     * @param string $message
     * @param array $context
     */
    public static function addLog(int $level, string $message, array $context = []): void
    {
        $appLogPath = $_ENV['APP_LOG_PATH'] ?? self::APP_LOG_PATH;
        $logFile = (empty($_SERVER['DOCUMENT_ROOT']))
            ? $appLogPath
            : $_SERVER['DOCUMENT_ROOT'] . '/' . $appLogPath;
        $log = new Logger('Application');
        $log->pushHandler(new StreamHandler($logFile));
        $log->addRecord($level, $message, $context);
    }
}