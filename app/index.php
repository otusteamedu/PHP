<?php

require 'vendor/autoload.php';

use Fdor\SimpleSumStrategy;
use Fdor\RoundSumStrategy;
use Fdor\Calc;

if ($argc !== 3) {
    echo 'Wrong argument count (must be 2)' . PHP_EOL;
    die;
}

$a = $argv[1];
$b = $argv[2];

$simpleSumStrategy = new SimpleSumStrategy();
$roundSumStrategy = new RoundSumStrategy($simpleSumStrategy);

$calc = new Calc($simpleSumStrategy);
echo 'Simple sum strategy: ' . $calc->execute($a, $b) . PHP_EOL;

$calc->setStrategy($roundSumStrategy);
echo 'Round sum strategy: ' . $calc->execute($a, $b) . PHP_EOL;
