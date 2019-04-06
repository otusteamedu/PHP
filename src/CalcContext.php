<?php

namespace HW5_1;

class CalcContext
{
    /**
     * @var Operation
     */
    private $operation;

    /**
     * CalcContext constructor.
     * @param Operation $operation
     */
    public function __construct(Operation $operation)
    {
        $this->operation = $operation;
    }

    public function calculation(Stack $stack): void
    {
        $this->operation->calculate($stack);
    }
}
