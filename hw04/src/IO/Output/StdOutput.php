<?php

namespace App\IO\Output;


class StdOutput implements Output
{
    public function write(string $message): void
    {
        echo($message);
    }

    public function writeLn(string $message): void
    {
        echo $message . PHP_EOL;
    }

    public function info(string $message): void
    {
        $this->writeLn("\e[36m" . $message . "\e[39m");
    }

    public function error(string $message): void
    {
        $this->writeLn("\e[31m" . $message .  "\e[39m");
    }
}
