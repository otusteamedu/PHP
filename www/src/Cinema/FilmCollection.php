<?php

namespace Tirei01\Hw12\Cinema;

use Tirei01\Hw12\Collection;

class FilmCollection extends Collection
{

    public function targetClass(): string
    {
        return Film::class;
    }
}