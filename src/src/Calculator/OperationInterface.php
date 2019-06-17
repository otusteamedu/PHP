<?php

namespace App\Calculator;

use App\Exception\CalculationException;
use App\Exception\InputException;

/**
 * Интерфейс математической операции (интерфейс стратегии)
 *
 * @package App\Calculator
 */
interface OperationInterface
{
    /**
     * Производит операцию и возвращает результат
     *
     * @param float $a первый аргумент
     * @param float $b второй аргумент
     * @return mixed
     *
     * @throws InputException
     * @throws CalculationException
     */
    public function execute(float $a, float $b): float;
}
