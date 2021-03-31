<?php

require_once '../bootstrap/bootstrap.php';

use Otus\App;
use Otus\Message\Message;
use Otus\Response\JsonResponse;

try {
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    Message::showMessage(JsonResponse::respond(['message' => $e->getMessage()],$e->getCode()));
}