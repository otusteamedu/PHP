<?php

use App\ConsoleKernel;

require_once('./vendor/autoload.php');
//app.php will be for console

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $app = new ConsoleKernel();
    $app->run($argv);
} catch (Exception $e) {
    echo $e->getMessage();
}
