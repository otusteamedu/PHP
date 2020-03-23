<?php

namespace App\Util\Logger;

interface LoggerInterface
{
    public function info(string $message): void;
    public function error(string $message): void;
    public function exception(\Throwable $t): void;
    public function newLine(): void;
}