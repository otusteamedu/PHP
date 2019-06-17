<?php

namespace App\Calculator;

/**
 * Класс калькулятора (контекст)
 *
 * @package App\Calculator
 */
class Calculator
{
    /**
     * @var OperationInterface производимая операция (стратегия)
     */
    private $operation;

    public function __construct(OperationInterface $operation)
    {
        $this->operation = $operation;
    }

    /**
     * Произвести операцию и получить результат
     *
     * @param float $a первый аргумент
     * @param float $b второй аргумент
     * @return mixed результат операции
     * @throws \App\Exception\CalculationException
     * @throws \App\Exception\InputException
     */
    public function calculate(float $a, float $b): float
    {
        return $this->operation->execute($a, $b);
    }
}
