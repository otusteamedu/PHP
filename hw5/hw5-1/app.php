<?php

require_once 'vendor/autoload.php';

use Src\App;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}