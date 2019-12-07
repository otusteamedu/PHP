<?php

declare(strict_types=1);

namespace App\IO;

use App\Contracts\IO\Output;

class StdError implements Output
{
    /**
     * @inheritDoc
     */
    public function write(string $message): void
    {
        fwrite(\STDERR, $message);
    }

    /**
     * @inheritDoc
     */
    public function writeLn(string $message): void
    {
        fwrite(\STDERR, $message . PHP_EOL);
    }

    /**
     * @inheritDoc
     */
    public function info(string $message): void
    {
        $this->writeLn($message);
    }

    /**
     * @inheritDoc
     */
    public function error(string $message): void
    {
        $this->writeLn("\e[31m" . $message .  "\e[39m");
    }
}
