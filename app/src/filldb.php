<?php

include_once __DIR__ . '/../vendor/autoload.php';

use App\Db\TableGateway;

if (!isset($argv[1])) {
    throw new InvalidArgumentException('No argument specified');
}



$filmTable = new TableGateway('film', ['name']);

for ($i = 0; $i < $argv[1]; $i++) {
    echo $filmTable->insert(['name' => 'Терминатор 3']);
}

var_dump($argv[1]);

