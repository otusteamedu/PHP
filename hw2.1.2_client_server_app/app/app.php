<?php

use App\App;

require_once __DIR__ . "/vendor/autoload.php";

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}