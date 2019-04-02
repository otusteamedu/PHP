<?php

namespace Calc\Operations;

class Addition extends Operation implements OperationInterface
{
    public function perform(): int
    {
        return $this->x + $this->y;
    }
}
