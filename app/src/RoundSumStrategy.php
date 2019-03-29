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
     * @param StrategyInterface $simpleSumStrategy
     */
    public function setSimpleSumStrategy(StrategyInterface $simpleSumStrategy): void
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