<?php

namespace timga\calculator;

class CalculationStrategyDivide implements CalculationStrategy
{
    public function calculate(float $aValue, float $bValue): float
    {
        if ($bValue === 0.0) {
            die("Error: division by zero!");
        }
        $result = $aValue / $bValue;
        return $result;
    }
}