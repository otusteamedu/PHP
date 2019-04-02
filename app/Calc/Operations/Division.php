<?php

namespace Calc\Operations;

class Division extends Operation implements OperationInterface
{
    public function perform(): int
    {
        return $this->x / $this->y;
    }
}
