<?php

use \Services\Spider;

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

var_dump((new Spider(new \Sources\Animevost(), new \DB\Mongodb()))
    ->getTop());




