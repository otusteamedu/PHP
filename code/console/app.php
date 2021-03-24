<?php

use App\AppConsole;

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = new AppConsole();
    $app->run();
}
catch(Exception $e){
    dump($e);
}

function dump(\Exception $e)
{
    echo $e->getMessage(), PHP_EOL;
    echo $e->getFile() . ': ' . $e->getLine(), PHP_EOL;
}
