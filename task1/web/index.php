<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\ConfigIni;
use App\Core\WebApplication;

$configFiles = [
    __DIR__ . '/../config/main.ini',
];
$config = (new ConfigIni())->loadFile($configFiles);
$app = new WebApplication($config);
$app->run();