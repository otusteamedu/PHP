<?php

use Otus\Sockets\App;

require_once(__DIR__.'/../bootstrap/app.php');

try {
    $app = new App();
    $app->run();
} catch (Throwable $throwable) {
    echo 'Error: ', $throwable->getMessage(), PHP_EOL;
}
