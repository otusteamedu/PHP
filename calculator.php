<?php

require 'vendor/autoload.php';

use nvggit\Calculator;
use nvggit\ValidateInput;
use nvggit\Helper;

$validator = new ValidateInput($argv, $argc);
if($validator->validate() && $validator->isHelperArgsCompareDefault()){
    echo (new Helper($argv, $argc))->getHelper();
    die();
}
echo (new Calculator())->exec($validator->getOperator(), $validator->getArg1(), $validator->getArg2()) . "\n";