<?php
include 'vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    print_r($e->getMessage());
}
