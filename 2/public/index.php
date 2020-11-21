<?php

require_once '../vendor/autoload.php';

use Mar4ehk0\Helloword;

try {
    $app = new Helloword();
    $app->run();
} catch (Exception $e) {
}
