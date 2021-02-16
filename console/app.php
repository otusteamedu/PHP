<?php

use App\App;

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = new App($argv);
    $app->run();
}
catch(Exception $e){
    if ($e instanceof InvalidArgumentException) {
        echo 'Usage: ' . $argv[0] . ' server|client', PHP_EOL;
    }
}
