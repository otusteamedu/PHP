<?php

require_once "vendor/autoload.php";

use timga\calculator\Input;
use timga\calculator\Calculator;
use timga\calculator\ArgumentValidator;

// Input & validation
$input = new Input($argc, $argv);
$validator = new ArgumentValidator();
if (!$validator->validate($input)) {
    $validator->showErrors();
}

// Calculator
$calculator = new Calculator();
echo $calculator->calculate($input);