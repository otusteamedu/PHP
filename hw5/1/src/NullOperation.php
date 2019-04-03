<?php


namespace HW5_1;

class NullOperation implements Operation
{

    /**
     * NullOperation constructor.
     */
    public function __construct()
    {
    }

    public function calculate(Stack $stack): float
    {
        return 0.0;
    }
}