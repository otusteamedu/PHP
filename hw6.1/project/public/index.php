<?php
require __DIR__.'/../vendor/autoload.php';

use AI\backend_php_hw6_1\App;
use AI\backend_php_hw6_1\Exceptions\MyException;

try {
    $app = new App(__DIR__ . '/../config.ini');
    $app->run();
} catch (InvalidArgumentException | MyException $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
