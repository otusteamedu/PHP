<?php

namespace Tirei01\Hw12\Storage\Collection;

use Tirei01\Hw12\Collection;

class Category extends Collection
{
    public function targetClass(): string
    {
        return static::class;
    }
}