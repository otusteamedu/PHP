<?php

namespace timga\calculator;


class CalculationStrategyAdd implements CalculationStrategy
{

    public function calculate(float $aValue, float $bValue):float
    {
        $result = $aValue + $bValue;
        return $result;
    }
}