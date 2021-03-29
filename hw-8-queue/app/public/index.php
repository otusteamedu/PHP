<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\App8;

try {
    $app = new App8();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
