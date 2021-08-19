<?php

namespace app\Logger;


use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\HtmlFormatter;


class ApplicationLogger
{

    /**
     * Добавляет запись в log-файл
     *
     * @param int $level
     * @param string $message
     * @param array $context
     */
    public static function addLog(int $level, string $message, $context = []): void
    {
        $log = new Logger('App');
        $log->pushHandler(new StreamHandler($_ENV['APP_LOG_PATH']));
        $log->addRecord($level, $message, $context);
    }
}