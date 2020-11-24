<?php

use Otus\Exceptions\ApiExceptionHandler;
use Otus\Http\App;

require __DIR__.'/../vendor/autoload.php';

try {
    $app = new App(dirname(__DIR__).'/');
    $app->run();
} catch (Throwable $throwable) {
    $handler = new ApiExceptionHandler();
    $handler->render($throwable);
}