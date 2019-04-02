<?php

namespace nvggit;

/**
 * Class Substract
 * @package application\src\Calculator
 */
class Substract implements CalculatorInterface
{
    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    public function exec(float $a, float $b): float
    {
        return $a - $b;
    }
}