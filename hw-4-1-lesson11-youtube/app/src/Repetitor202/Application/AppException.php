<?php


namespace Repetitor202\Application;


use Exception;

class AppException extends Exception
{
    private static function throwException(string $message): void
    {
        throw (new parent($message . PHP_EOL));
    }

    public static function needCliMode(): void
    {
        self::throwException('Need to run in cli mode.');
    }

    public static function undefinedArgv(string $argv): void
    {
        if (php_sapi_name() === 'cli') {
            self::throwException("Undefined argv $argv.");
        }
    }

    public static function argvIsRequired(): void
    {
        self::throwException('Argv is required.');
    }

    public static function keyIsRequired(string $key): void
    {
        self::throwException('Key ' . $key . ' is required.');
    }
}