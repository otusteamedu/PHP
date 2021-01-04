<?php


namespace App\Api;


interface LoggerInterface
{
    public function writeln(string $message): void;
}