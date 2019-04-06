#!/usr/local/bin/php
<?php

use HW5_1\Calculator as Calc;
use HW5_1\InfixExpresion;

require_once 'vendor/autoload.php';

$name = array_shift($argv);
if (count($argv) > 0) {
    $calculator = new Calc(implode(InfixExpresion::SEPARATOR, $argv));
    echo sprintf("%2.8f \n", $calculator->calculate());
} else {
    echo sprintf("Usage: %s <expresion> \n", basename($name));
}
