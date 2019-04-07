<?php

namespace nvggit;

use DivisionByZeroError;

/**
 * Class Divide
 * @package application\src\Calculator
 */
class Divide implements CalculatorInterface
{
    /**
     * @param float $a
     * @param float $b
     * @return float|int
     */
    public function exec(float $a, float $b): float
    {
        if ($b === 0.0)
            throw new DivisionByZeroError('Division by zero!');
        return $a / $b;
    }
}