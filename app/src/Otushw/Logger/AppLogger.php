<?php


namespace Otushw\Logger;

use Monolog\Logger;

class AppLogger
{
    private $instance = null;

    private static function instance(): Logger
    {
        return LoggerFactory::getInstance();
    }

    public static function addEmergency(string $message, array $context = []): void
    {
        $log = self::instance();
        $log->emergency($message, $context);
    }

    public static function addAlert(string $message, array $context = []): void
    {
        $log = self::instance();
        $log->alert($message, $context);
    }

    public static function addCriticale(string $message, array $context = []): void
    {
        $log = self::instance();
        $log->critical($message, $context);
    }

    public static function addError(string $message, array $context = []): void
    {
        $log = self::instance();
        $log->error($message, $context);
    }

    public static function addWarning(string $message, array $context = []): void
    {
        $log = self::instance();
        $log->warning($message, $context);
    }

    public static function addNotice(string $message, array $context = []): void
    {
        $log = self::instance();
        $log->notice($message, $context);
    }

    public static function addInfo(string $message, array $context = []): void
    {
        $log = self::instance();
        $log->info($message, $context);
    }

    public static function addDebug(string $message, array $context = []): void
    {
        $log = self::instance();
        $log->debug($message, $context);
    }
}