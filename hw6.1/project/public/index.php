<?php
require __DIR__.'/../vendor/autoload.php';

use AI\backend_php_hw6_1\App;

if (PHP_SAPI == 'cli') {
    $_SERVER['DOCUMENT_ROOT'] = __DIR__;
}

try {
    $app = new App();
    $app->run();
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
