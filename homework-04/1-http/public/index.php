<?php

use Otus\Http\App;

require __DIR__.'/../vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Throwable $throwable) {
    echo $throwable->getMessage();
}
