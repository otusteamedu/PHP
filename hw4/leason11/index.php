<?php
require 'vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo "Error: ".$e->getMessage();
    echo "\n\n";
}
