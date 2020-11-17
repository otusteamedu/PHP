<?php

use App\Controllers\Api\QueueApiController;

require_once 'src/bootstrap.php';

try {
    $queueApiController = new QueueApiController();
    $queueApiController->run();
} catch (RuntimeException $e) {
    echo $e->getMessage();
}