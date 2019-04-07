<?php

namespace timga\calculator;


class CalculationStrategySubtract implements CalculationStrategy
{

    public function calculate(float $aValue, float $bValue): float
    {
        $result = $aValue - $bValue;
        return $result;
    }
}