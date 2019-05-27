<?php

include_once __DIR__ . '/../vendor/autoload.php';

use App\Db\TableGateway;

$filmTable = new TableGateway('film', ['name']);
$filmTable->insert(['name' => 'Терминатор']);

