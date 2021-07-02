<?php


namespace App\Core;


interface LoggerInterface
{
    public function writeln(string $message): void;
}