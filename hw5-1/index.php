<?php

require_once "vendor/autoload.php";
define('ACTION',1);
define('VALUE_A',2);
define('VALUE_B',3);

use timga\calculator\Calculator;
use timga\calculator\ArgumentValidator;
use timga\calculator\CalculationStrategyAdd;
use timga\calculator\CalculationStrategySubtract;
use timga\calculator\CalculationStrategyDivide;

$validator = new ArgumentValidator($argc, $argv);
$action = $validator->getAction(ACTION);
$aValue = $validator->getValue(VALUE_A);
$bValue = $validator->getValue(VALUE_B);

// Choose strategy
switch($action) {
    case "add": $strategy = new CalculationStrategyAdd(); break;
    case "subtract": $strategy = new CalculationStrategySubtract(); break;
    case "divide": $strategy = new CalculationStrategyDivide(); break;
}

// Calculator
$calculator = new Calculator($strategy);
echo $calculator->calculate($aValue, $bValue);