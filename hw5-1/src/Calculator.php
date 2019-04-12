<?php

namespace timga\calculator;

class Calculator
{
    private $strategy;

    public function __construct(CalculationStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setStrategy(CalculationStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function calculate(float $aValue, float $bValue): float
    {
        $result = $this->strategy->calculate($aValue, $bValue);
        return $result;
    }
}