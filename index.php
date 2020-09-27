<?php

require $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use Controllers\API\EventApiController;

ini_set('html_errors', 0);
session_start();
$eventAPIController = new EventApiController();
$eventAPIController->run();