<?php

namespace App\IO\Output;

class StdError implements Output
{
    public function write(string $message): void
    {
        fwrite(\STDERR, $message);
    }

    public function writeLn(string $message): void
    {
        fwrite(\STDERR, $message . PHP_EOL);
    }

    public function info(string $message): void
    {
        $this->writeLn($message);
    }

    public function error(string $message): void
    {
        $this->writeLn("\e[31m" . $message .  "\e[39m");
    }
}
