<?php
include 'vendor/autoload.php';

$config = require '../common/config/main.php';

try {
    $app = new App($config);
    $app->run();
} catch (Exception $e) {
    print_r(['error' => $e->getMessage()]);
}
