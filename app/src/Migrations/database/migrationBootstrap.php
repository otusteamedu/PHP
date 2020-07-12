<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../../../.env');

$capsule = new Capsule();
$capsule->addConnection([
    'driver' => $_ENV['DRIVER'],
    'host' => $_ENV['HOST'],
    'database' => $_ENV['DATABASE'],
    'username' => $_ENV['USERNAME'],
    'password' => $_ENV['PASSWORD'],
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();