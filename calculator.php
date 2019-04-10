<?php

require 'vendor/autoload.php';

use nvggit\Calculator;
use nvggit\ValidateInput;
use nvggit\Helper;
use nvggit\Input;

$input = new Input($argv, $argc);
$validator = new ValidateInput($argv, $argc);
if (!$validator->validate()) {
    $error = $validator->getError();
    $helper = new Helper($input->getOperator());
    echo $helper->getMessageForError($error);
    die();
}
$calculator = new Calculator();
echo ($calculator->exec($input->getOperator(), $input->getArg1(), $input->getArg2())) . "\n";