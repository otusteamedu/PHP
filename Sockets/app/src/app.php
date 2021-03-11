<?php

use App\Core\App;

require_once('../vendor/autoload.php');
require_once('bootstrap.php');

try {
    $app = new App($argv);
    $app->run();
} catch(Exception $e){
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}