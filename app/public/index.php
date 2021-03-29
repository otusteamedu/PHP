<?php

require_once '../bootstrap/bootstrap.php';

use Otus\App;
use Otus\Response\JsonResponse;

try {
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    JsonResponse::respond($e->getMessage(), $e->getCode());
}