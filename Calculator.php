#!/usr/bin/php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Calc\SumStrategy;
use Calc\DivideStrategy;
use Calc\Calculate;

if ($argc !== 4) {
    echo 'Введите строку, числа и действие разделите пробелом (например 1 + 1 или 1 / 4)' . PHP_EOL;
    die;
}

$digit1 = $argv[1];
$action = $argv[2];
$digit2 = $argv[3];

/*
if ($action == '/' && $digit2 == 0) {
    echo 'Деление на ноль' . PHP_EOL;
    die;
}
*/

$sumStrategy = new sumStrategy();
$divideStrategy = new divideStrategy();

switch ($action) {
    case '+': 
		$strategy = $sumStrategy; 
		break;
    case '/': 
		$strategy = $divideStrategy;
		break;
}

$calc = new Calculate($strategy);
$result = $calc->execute($digit1, $digit2, $action);

if ($result) {
    echo 'Результат: ' . $result . PHP_EOL;
} else {
    echo 'Неверно введены данные или деление на ноль' . PHP_EOL;
}


