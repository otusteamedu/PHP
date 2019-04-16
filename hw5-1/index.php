<?php

require_once "vendor/autoload.php";
define('ACTION', 1);
define('VALUE_A', 2);
define('VALUE_B', 3);

use timga\calculator\Input;
use timga\calculator\Calculator;
use timga\calculator\ArgumentValidator;
use timga\calculator\CalculationStrategyAdd;
use timga\calculator\CalculationStrategySubtract;
use timga\calculator\CalculationStrategyDivide;
use timga\calculator\CalculationStrategyMultiply;
use timga\calculator\CalculationStrategyPow;

$input = new Input($argc, $argv);
$validator = new ArgumentValidator($input);
$action = $input->getAction();
$aValue = $input->getValueA();
$bValue = $input->getValueB();

// Choose strategy
switch($action) {
    case "add": $strategy = new CalculationStrategyAdd(); break;
    case "subtract": $strategy = new CalculationStrategySubtract(); break;
    case "divide": $strategy = new CalculationStrategyDivide(); break;
    case "multiply": $strategy = new CalculationStrategyMultiply(); break;
    case "pow": $strategy = new CalculationStrategyPow(); break;
}

// Calculator
$calculator = new Calculator($strategy);
echo $calculator->calculate($aValue, $bValue);