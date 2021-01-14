<?php

require_once '../vendor/autoload.php';

use Homework\Homework;



try {
    $app = new Homework();
    $app->check();
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage();
}


