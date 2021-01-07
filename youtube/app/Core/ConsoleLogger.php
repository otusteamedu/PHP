<?php


namespace App\Core;


use App\Api\LoggerInterface;

class ConsoleLogger implements LoggerInterface
{
    public function writeln(string $message): void
    {
        echo $message.PHP_EOL;
    }
}