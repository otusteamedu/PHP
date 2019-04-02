<?php

namespace nvggit;

/**
 * Class Multiply
 * @package application\src\Calculator
 */
class Multiply implements CalculatorInterface
{
    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    public function exec(float $a, float $b): float
    {
        return $a * $b;
    }
}