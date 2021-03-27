<?php

use App\Console\App;

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
}
catch(Exception $e){
    echo $e->getMessage(), PHP_EOL;
    echo $e->getFile() . ': ' . $e->getLine(), PHP_EOL;
}
