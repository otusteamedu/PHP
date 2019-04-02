<?php

namespace Calc\Operations;

class Multiplication extends Operation implements OperationInterface
{

    public function perform(): int
    {
        return $this->x * $this->y;
    }
}
