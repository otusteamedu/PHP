<?php

require 'vendor/autoload.php';

use nvggit\Calculator;
use nvggit\ValidateInput;
use nvggit\Helper;

(new ValidateInput($argv))->validate();
if($argc === ValidateInput::HELPER_COUNT_ARGUMENTS){
    echo (new Helper($argv))->getHelper();
    die();
}

echo (new Calculator())->exec($argv[2], $argv[1], $argv[3]) . "\n";