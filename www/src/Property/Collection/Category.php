<?php

namespace Tirei01\Hw12\Property\Collection;

use Tirei01\Hw12\Collection;

class Category extends Collection
{
    public function targetClass(): string
    {
        return \Tirei01\Hw12\Property\Category::class;
    }
}