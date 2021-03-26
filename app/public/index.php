<?php

require __DIR__ . '/../vendor/autoload.php';

use Otushw\App;
use Otushw\Logger\AppLogger;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    AppLogger::addError($e->getMessage());
}
