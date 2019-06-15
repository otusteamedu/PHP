<?php
namespace Calc;

class DivideStrategy implements StrategyInterface
{
    public function calc(float $a, float $b): float
    {
	if ($b == 0) return false;
        return $a / $b;
    }
    
}