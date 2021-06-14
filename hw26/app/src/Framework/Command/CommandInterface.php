<?php

declare(strict_types=1);

namespace App\Framework\Command;

interface CommandInterface
{
    public function execute(): void;
}