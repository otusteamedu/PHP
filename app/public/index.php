<?php

use App\App;
use App\Response\Response;

require_once '../bootstrap/bootstrap.php';

try {
    $app = new App();
    $app->run();
} catch (\Throwable $e) {
    Response::send($e->getCode(), $e->getMessage());
}
