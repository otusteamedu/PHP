<?php

namespace Src\Iterators;

use Src\Entities\PlayGroundCell;

interface PlayGroundCellsIterator
{
    public function next(): PlayGroundCell;
    public function hasMore(): bool;
}