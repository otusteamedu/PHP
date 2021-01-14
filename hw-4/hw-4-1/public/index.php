<?php

require_once '../vendor/autoload.php';

use Homework\Homework;



try {
    $app = new Homework();
    $app->run();
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage(), "\n";
}