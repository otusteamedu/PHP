<?php

use App\Controllers\Api\TaskApiController;

require_once 'src/bootstrap.php';

try {
    $taskApiController = new TaskApiController();
    $taskApiController->run();
} catch (RuntimeException $e) {
    echo $e->getMessage();
}