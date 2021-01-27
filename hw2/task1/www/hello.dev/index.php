<?php

require "vendor/autoload.php";
use App\Main;

try {
    $app = new Main();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}