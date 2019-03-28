<?php

namespace Fdor;

/**
 * Interface StrategyInterface
 * @package Fdor
 */
interface StrategyInterface
{
    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    public function calc(float $a, float $b): float;
}