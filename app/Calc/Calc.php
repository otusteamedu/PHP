<?php

namespace Calc;

use Calc\Operations\OperationInterface;

class Calc
{
    private $operation;

    public function __construct(OperationInterface $operation)
    {
        $this->operation = $operation;
    }

    public function setOperation(OperationInterface $operation)
    {
        $this->operation = $operation;
    }

    public function doMath() :int
    {
        return $this->operation->perform();
    }
}
