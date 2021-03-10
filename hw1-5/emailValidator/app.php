<?php
require_once 'bootstrap.php';

use Src\App;

try {
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}