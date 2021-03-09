<?php

require_once '../vendor/autoload.php';

use \RedBeanPHP\R as R;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

R::setup();