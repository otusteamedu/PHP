#!/usr/bin/php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Calc\SumStrategy;
use Calc\Calculate;

if ($argc !== 3) {
    echo 'Введите две цифры' . PHP_EOL;
    die;
}

$a = $argv[1];
$b = $argv[2];

$sumStrategy = new sumStrategy();

$calc = new Calculate($sumStrategy);

echo 'Сумма: ' . $calc->execute($a, $b) . PHP_EOL;

