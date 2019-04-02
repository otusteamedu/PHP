<?php

namespace nvggit;

/**
 * Interface CalculatorInterface
 * @package application\src\CalculatorInterface
 */
interface CalculatorInterface
{
    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    public function exec(float $a, float $b): float ;
}