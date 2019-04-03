<?php

namespace Calc\Operations;

use InvalidArgumentException;

class Division extends Operation implements OperationInterface
{
    public function perform(): int
    {
        if (is_float($this->x / $this->y)) {
            throw new InvalidArgumentException('float values after division are not allowed!');
        }
        return $this->x / $this->y;
    }
}
