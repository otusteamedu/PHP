<?php

require_once '../bootstrap/bootstrap.php';

use App\App;
use App\Log\Log;
use Monolog\Logger;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    Log::getInstance()->addRecord($e->getMessage(), Logger::ERROR);
}