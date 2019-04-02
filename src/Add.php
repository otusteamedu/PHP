<?php

namespace nvggit;

/**
 * Class Add
 * @package application\src\Calculator
 */
class Add implements CalculatorInterface
{
    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    public function exec(float $a, float $b): float
    {
        return $a + $b;
    }

}