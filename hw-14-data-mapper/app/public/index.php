<?php

use App\App;
use App\Log\Log;
use Monolog\Logger;

try {
    require_once '../bootstrap.php';

    $app    = new App();
    $result = $app->run();

    Log::getInstance()->addRecord($result);
} catch (Exception $e) {
    Log::getInstance()->addRecord($e->getMessage(), Logger::ERROR);
}

phpinfo();