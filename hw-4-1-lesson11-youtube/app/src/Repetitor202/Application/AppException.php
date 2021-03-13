<?php


namespace Repetitor202\Application;


use Exception;

class AppException
{
    public static function undefinedArgv(string $argv)
    {
        if (php_sapi_name() === 'cli') {
            throw new Exception("Undefined argv $argv." . PHP_EOL);
        }
    }

    public static function needCliMode()
    {
        throw new Exception('Need to run in cli mode.' . PHP_EOL);
    }

    public static function needChangeEnvFile()
    {
        throw new Exception('Need to change .env file.' . PHP_EOL);
    }

    public static function argvIsRequired()
    {
        throw new Exception('Argv is required.' . PHP_EOL);
    }

    public static function keyIsRequired(string $key)
    {
        throw new Exception('Key ' . $key . ' is required.' . PHP_EOL);
    }

    public static function infoIsAbsent()
    {
        throw new Exception('Info in database is absent.' . PHP_EOL);
    }
}