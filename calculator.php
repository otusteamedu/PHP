<?php

require 'vendor/autoload.php';

use nvggit\Calculator;
use nvggit\Add;
use nvggit\Substract;
use nvggit\Multiply;
use nvggit\Divide;

if ($argc === 2 && in_array($argv[1], ["-h", "-help"])):
    echo "Usage: calculator.php <arg1> <operator> <arg2> \n";
    echo "<operator> add - add, sub - substract, mul - multiply, div - divide \n";
    die();
elseif ($argc !== 4):
    echo "Wrong count of arguments! Expected 3! \n";
    die();
endif;

$a = $argv[1];
$b = $argv[3];
$operator = $argv[2];

if ($operator === "sum"):
    $calculator = new Calculator(new Add());
    echo $calculator->exec($a, $b) . "\n";
elseif ($operator === "sub"):
    $calculator = new Calculator(new Substract());
    echo $calculator->exec($a, $b) . "\n";
elseif ($operator === "mul"):
    $calculator = new Calculator(new Multiply());
    echo $calculator->exec($a, $b) . "\n";
elseif ($operator === "div"):
    $calculator = new Calculator(new Divide());
    echo $calculator->exec($a, $b) . "\n";
endif;