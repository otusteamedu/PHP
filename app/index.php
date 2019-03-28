<?php

require 'vendor/autoload.php';

use Fdor\Strategy1;
use Fdor\Strategy2;
use Fdor\Calc;

if ($argc !== 3) {
    echo 'Wrong argument count (must be 2)' . PHP_EOL;
    die;
}

$a = $argv[1];
$b = $argv[2];

$strategy1 = new Strategy1();
$strategy2 = new Strategy2();

$calc1 = new Calc($strategy1);
$calc2 = new Calc($strategy2);

echo 'Strategy1: ' . $calc1->sum($a, $b) . PHP_EOL;
echo 'Strategy2 (round): ' . $calc2->sum($a, $b) . PHP_EOL;
