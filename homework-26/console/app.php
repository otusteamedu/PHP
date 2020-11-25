<?php

use Otus\Console\App;
use Otus\Exceptions\ConsoleExceptionHandler;

require __DIR__.'/../vendor/autoload.php';

try {
    $app = new App(dirname(__DIR__).'/');
    $app->run();
} catch (Throwable $throwable) {
    $handler = new ConsoleExceptionHandler();
    $handler->render($throwable);
}
