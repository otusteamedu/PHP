<?php

declare(strict_types=1);

namespace App\IO;

use App\Contracts\IO\Output;

class StdOutput implements Output
{
    /**
     * @inheritDoc
     */
    public function write(string $message): void
    {
        echo($message);
    }

    /**
     * @inheritDoc
     */
    public function writeLn(string $message): void
    {
        echo $message . PHP_EOL;
    }

    /**
     * @inheritDoc
     */
    public function info(string $message): void
    {
        $this->writeLn("\e[36m" . $message . "\e[39m");
    }

    /**
     * @inheritDoc
     */
    public function error(string $message): void
    {
        $this->writeLn("\e[31m" . $message .  "\e[39m");
    }
}
