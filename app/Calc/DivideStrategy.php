<?php
namespace Calc;

class DivideStrategy implements StrategyInterface
{

    public function calc(float $a, float $b): float
    {
        return $a / $b;
    }
    
}