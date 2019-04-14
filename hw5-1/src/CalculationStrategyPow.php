<?php

namespace timga\calculator;

class CalculationStrategyPow implements CalculationStrategy
{
    public function calculate(float $aValue, float $bValue): float
    {
        $result = $aValue ** $bValue;
        return $result;
    }
}