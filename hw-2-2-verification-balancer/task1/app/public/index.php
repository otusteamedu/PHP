<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
