<?php

declare(strict_types=1);

namespace App\Framework\Command;

use App\Framework\Console\ConsoleInterface;

interface CommandInterface
{
    public function run(ConsoleInterface $console): void;
}