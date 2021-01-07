<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\WebApplication;

$configFile =  __DIR__ . '/../config/main.ini';

$app = new WebApplication($configFile);
$app->run();