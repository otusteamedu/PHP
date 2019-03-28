<?php

namespace Fdor;

/**
 * Class Srategy1
 * @package Fdor
 */
class Strategy1 implements StrategyInterface
{
    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    public function calc(float $a, float $b): float
    {
        return $a + $b;
    }
}