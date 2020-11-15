<?php

use App\Controllers\Api\QueueApiController;

require_once 'src/bootstrap.php';

$queueApiController = new QueueApiController();
$queueApiController->run();