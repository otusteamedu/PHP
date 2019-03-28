<?php

namespace Fdor;

/**
 * Class Calc
 * @package Fdor
 */
class Calc
{
    /**
     * @var StrategyInterface
     */
    private $strategy;

    /**
     * Calc constructor.
     * @param StrategyInterface $strategy
     */
    public function __construct(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    public function sum(float $a, float $b): float
    {
        return $this->strategy->calc($a, $b);
    }
}
