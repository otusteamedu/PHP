<?php


namespace App\Core;


use App\Core\LoggerInterface;

class FileLogger implements LoggerInterface
{
    public function writeln(string $message): void
    {
        file_put_contents('log.txt', $message.PHP_EOL, FILE_APPEND);
    }
}