<?php

use App\Log\Log;
use Monolog\Logger;

try {
    require_once '../bootstrap.php';
} catch (Exception $e) {
    Log::getInstance()->addRecord($e->getMessage(), Logger::ERROR);
}