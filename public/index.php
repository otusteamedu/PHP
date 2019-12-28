<?php

use Evrimedont\CalculatorService;

require dirname(__DIR__).'/vendor/autoload.php';

$calculator = new CalculatorService();

$sum = $calculator->addition(10, 20);

echo $sum;