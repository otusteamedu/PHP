<?php
require_once 'bootstrap/init.php';

use Src\App;

try {
    $app = new App($argv);
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}