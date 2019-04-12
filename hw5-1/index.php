<?php

require_once "vendor/autoload.php";

use timga\calculator\Calculator;
use timga\calculator\InputValidator;
use timga\calculator\CalculationStrategyAdd;
use timga\calculator\CalculationStrategySubtract;

// Input data
$action = $argv[1] ?? "error";
$aValue = $argv[2] ?? "error";
$bValue = $argv[3] ?? "error";
if (!InputValidator::validateAction($action)) die("Error! Incorrect action: $action");
if (!InputValidator::validateValue($aValue)) die("Error! Incorrect value: $aValue");
if (!InputValidator::validateValue($bValue)) die("Error! Incorrect value: $bValue");

// Choose strategy
switch($action) {
    case "add": $strategy = new CalculationStrategyAdd(); break;
    case "subtract": $strategy = new CalculationStrategySubtract(); break;
}

// Calculator
$calculator = new Calculator($strategy);
echo $calculator->calculate($aValue, $bValue);