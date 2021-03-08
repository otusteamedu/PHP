<?php

use App\HttpKernel;

require_once('./vendor/autoload.php');

try {
    $app = new HttpKernel();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
