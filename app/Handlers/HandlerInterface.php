<?php

declare(strict_types=1);

namespace App\Handlers;

interface HandlerInterface
{
    public function handle(string $string): bool;
}
