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
        $messageType = self::setColorFor(self::COLOR__RED, 'ERROR: ');

        self::writeLn($messageType . $message);
    }

    public static function info($message): void
    {
        self::writeLn($message);
    }

    private static function setColorFor(string $color, $text): string
    {
        return "\033[{$color}{$text}\033[0m";
    }

    public static function lineBreak(): void
    {
        self::writeLn('');
    }

    private static function writeLn($message): void
    {
        self::write($message . PHP_EOL);
    }

    private static function write($message): void
    {
        echo $message;
    }

    public static function waitingForUserInput(string $prompt): string
    {
        do {
            $data = self::readLn($prompt);
            $data = trim($data);
        } while (empty($data));

        return $data;
    }

    private static function readLn(string $prompt): string
    {
        echo $prompt;

        return rtrim(fgets(STDIN));
    }

}