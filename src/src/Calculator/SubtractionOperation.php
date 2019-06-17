<?php

namespace App\Calculator;

/**
 * Операция сложения (стратегия)
 *
 * @package App\Calculator
 */
class SubtractionOperation implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute(float $a, float $b): float
    {
        return $a - $b;
    }
}
