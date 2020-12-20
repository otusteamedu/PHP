<?php

require '../vendor/autoload.php';

use App\App;

$mode = $argv[1] ?? '';

try {
    $app = new App();
    $app->run($mode);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}