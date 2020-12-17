<?php

require '../vendor/autoload.php';

use Socket\App;

$mode = $argv[1] ?? '';

try {
    $app = new App($mode);
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage().PHP_EOL;
}