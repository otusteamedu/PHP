<?php
namespace Calc;

class SumStrategy implements StrategyInterface
{

    public function calc(float $a, float $b): float
    {
        return $a + $b;
    }
    
}