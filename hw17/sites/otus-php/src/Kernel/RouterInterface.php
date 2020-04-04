<?php

declare(strict_types=1);

namespace App\Kernel;

interface RouterInterface
{
    public function findController(): string;
}
