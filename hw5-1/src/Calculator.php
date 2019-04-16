<?php

namespace timga\calculator;

class Calculator
{
    public function calculate(Input $input): float
    {
        $strategy = $this->chooseStrategy($input->getAction());
        $result = $strategy->calculate($input->getValueA(), $input->getValueB());
        return $result;
    }

    private function chooseStrategy($action)
    {
        switch($action) {
            case "add": return new CalculationStrategyAdd();
            case "subtract": return new CalculationStrategySubtract();
            case "divide": return new CalculationStrategyDivide();
            case "multiply": return new CalculationStrategyMultiply();
            case "pow": return new CalculationStrategyPow();
            default: exit("Error: Incorrect action!");
        }
    }
}