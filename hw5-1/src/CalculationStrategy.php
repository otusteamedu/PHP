<?php

namespace timga\calculator;


interface CalculationStrategy
{
    public function calculate(float $aValue, float $bValue);
}