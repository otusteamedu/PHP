<?php

require_once('./vendor/autoload.php');

try {
    $app = new \App\App();
    $app->run();
} catch (Exception $e) {
    $e->getMessage();
}

