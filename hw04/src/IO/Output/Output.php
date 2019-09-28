<?php

namespace App\IO\Output;

interface Output
{
    public function write(string $message): void;

    public function writeLn(string $message): void;

    public function info(string $message): void;

    public function error(string $message): void;
}
