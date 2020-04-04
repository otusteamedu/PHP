<?php

declare(strict_types=1);

namespace App\Kernel;

interface RequestInterface
{
    public function get(string $key): ?string;

    public function getAll(): array;
}
