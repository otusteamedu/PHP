<?php

namespace App\Services;

class Message
{
    public static function info(string $message): void
    {
        echo $message . PHP_EOL;
    }

    public static function error(string $message): void
    {
        echo "Ошибка: $message" . PHP_EOL;
    }

    public static function log(string $message): void
    {
        echo '[' . getmypid() . '] ' . date('Y-m-d H:i:s') . " $message" . PHP_EOL;
    }
}
