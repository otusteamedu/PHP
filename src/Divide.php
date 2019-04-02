<?php

namespace nvggit;

/**
 * Class Divide
 * @package application\src\Calculator
 */
class Divide implements CalculatorInterface
{
    /**
     * @param float $a
     * @param float $b
     * @return mixed
     */
    public function exec(float $a, float $b): float
    {
        if ($b !== 0.0)
            return $a / $b;
    }
}