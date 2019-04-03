<?php

namespace HW5_1;

class Operand implements Operation
{
    private $value;


    /**
     * Operand constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function calculate(Stack $stack): float
    {
        return $stack->push($this->value);
    }
}