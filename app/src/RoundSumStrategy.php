<?php

namespace Fdor;

/**
 * Class RoundSumStrategy
 * @package Fdor
 */
class RoundSumStrategy implements StrategyInterface
{
    /**
     * @var StrategyInterface
     */
    private $simpleSumStrategy;

    /**
     * RoundSumStrategy constructor.
     * @param StrategyInterface $simpleSumStrategy
     */
    public function __construct(StrategyInterface $simpleSumStrategy)
    {
        $this->simpleSumStrategy = $simpleSumStrategy;
    }

    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    public function calc(float $a, float $b): float
    {
        $sum = $this->simpleSumStrategy->calc($a, $b);

        return round($sum);
    }
}