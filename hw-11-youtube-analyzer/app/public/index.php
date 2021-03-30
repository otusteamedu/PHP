<?php

use App\App;
use App\Log\Log;
use Monolog\Logger;

try {
    require_once '../bootstrap/bootstrap.php';

    $app    = new App();
    $result = $app->run();
} catch (Exception $e) {
    Log::getInstance()->addRecord($e->getMessage(), Logger::ERROR);
}