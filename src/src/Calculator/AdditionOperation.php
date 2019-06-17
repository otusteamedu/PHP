<?php

namespace App\Calculator;

use App\Exception\InputException;

/**
 * Операция сложения (стратегия)
 *
 * @package App\Calculator
 */
class AdditionOperation implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute(float $a, float $b): float
    {
        return $a + $b;
    }
}
