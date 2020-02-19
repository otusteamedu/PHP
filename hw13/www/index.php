<?php

use App\Kernel\App;

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__));
$dotenv->load();

$app = new App;
$app->run();
