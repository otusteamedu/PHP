<?php

declare(strict_types=1);

namespace App\Contracts\IO;

interface Output
{
    /**
     * @param string $message
     */
    public function write(string $message): void;

    /**
     * @param string $message
     */
    public function writeLn(string $message): void;

    /**
     * @param string $message
     */
    public function info(string $message): void;

    /**
     * @param string $message
     */
    public function error(string $message): void;
}
