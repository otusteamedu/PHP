<?php

namespace nvggit;

/**
 * Class Calculator
 * @package application\src\Calculator
 */
class Calculator
{
    private $strategy;

    /**
     * Calculator constructor.
     * @param CalculatorInterface $strategy
     */
    public function __construct(CalculatorInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @param float $a
     * @param float $b
     * @return float
     */
    public function exec(float $a, float $b) : float
    {
        return $this->strategy->exec($a, $b);
    }
}