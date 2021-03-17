<?php

declare(strict_types=1);

namespace App\Console;

class Console
{

    private const COLOR__GREEN = '32m';
    private const COLOR__RED   = '31m';

    public static function success($message): void
    {
        $message = self::setColorFor(self::COLOR__GREEN, $message);

        self::writeLn($message);
    }

    public static function error($message): void
    {
        $message = self::setColorFor(self::COLOR__RED, $message);

        self::writeLn($message);
    }

    public static function info($message): void
    {
        self::writeLn($message);
    }

    public static function setColorFor(string $color, $text): string
    {
        return "\033[{$color}{$text}\033[0m";
    }

    private static function writeLn($message): void
    {
        self::write($message . PHP_EOL);
    }

    private static function write($message): void
    {
        echo $message;
    }

    public static function readLines(): array
    {
        stream_set_blocking(STDIN, false);

        $data = [];

        while (!feof(STDIN)) {
            if (false === $value = fgets(STDIN)) {
                break;
            }
            $data[] = rtrim($value);
        }

        return $data;
    }

}