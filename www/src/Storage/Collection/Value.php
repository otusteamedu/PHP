<?php

namespace Tirei01\Hw12\Storage\Collection;

use Tirei01\Hw12\Collection;

class Value extends Collection
{

    public function targetClass(): string
    {
        return static::class;
    }
}