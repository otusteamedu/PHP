<?php
namespace Calc;

interface StrategyInterface
{
    public function calc(float $a, float $b): float;
}