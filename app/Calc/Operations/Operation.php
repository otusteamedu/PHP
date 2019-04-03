<?php

namespace Calc\Operations;

use InvalidArgumentException;

abstract class Operation
{
    protected $x;
    protected $y;

    /**
     * @param $x
     * @param $y
     * @throws InvalidArgumentException
     */
    public function __construct($x, $y)
    {
        if (!is_int($x) || !is_int($y)) {
            throw new InvalidArgumentException('only int variables are allowed!');
        }

        if ($y === 0) {
            throw new InvalidArgumentException('division by zero is not allowed!');
        }

        $this->x = $x;
        $this->y = $y;
    }
}
