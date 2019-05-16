<?php

namespace timga\calculator;

use timga\calculator\Exceptions\DivisionByZeroException;

class CalculationStrategyDivide implements CalculationStrategy
{
    public function calculate(float $aValue, float $bValue): float
    {
        if ($bValue === 0.0) {
            throw new DivisionByZeroException();
        }
        $result = $aValue / $bValue;
        return $result;
    }
}