<?php

namespace Calc\Operations;

use InvalidArgumentException;

class Division extends Operation implements OperationInterface
{
    public function perform(): int
    {
        if ($this->y == 0) {
            throw new InvalidArgumentException('division by zero is not allowed!');
        }

        return $this->x / $this->y;
    }
}
