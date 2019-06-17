<?php

namespace App\Calculator;

use App\Exception\CalculationException;

/**
 * Операция сложения (стратегия)
 *
 * @package App\Calculator
 */
class DivisionOperation implements OperationInterface
{
    /**
     * {@inheritdoc}
     * @throws CalculationException
     */
    public function execute(float $a, float $b): float
    {
        if ($b === 0.0) {
            throw new CalculationException('Division by zero');
        }
        return $a / $b;
    }
}
