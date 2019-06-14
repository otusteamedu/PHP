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
        if (($a != (int)$a) || ($b != (int)$b)) {
            throw new InputException('Arguments must be integer values');
        }
        return $a + $b;
    }
}
