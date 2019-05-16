<?php

namespace timga\calculator;

use timga\calculator\Exceptions\CalcActionNotExistsException;

class Calculator
{
    public function calculate(Input $input): float
    {
        $strategy = $this->chooseStrategy($input->getAction());
        $result = $strategy->calculate($input->getValueA(), $input->getValueB());
        return $result;
    }

    public function chooseStrategy($action)
    {
        switch($action) {
            case "add": return new CalculationStrategyAdd();
            case "subtract": return new CalculationStrategySubtract();
            case "divide": return new CalculationStrategyDivide();
            case "multiply": return new CalculationStrategyMultiply();
            case "pow": return new CalculationStrategyPow();
            default: throw new CalcActionNotExistsException();
        }
    }
}