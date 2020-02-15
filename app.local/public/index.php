<?php

use Exceptions\RequestException;
use Responses\ErrorResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../bootstrap.php';

$request = Request::createFromGlobals();

try {
    $app    = new App();
    $result = $app->exec($request);
    
    $response = JsonResponse::create($result);
} catch (RequestException $e) {
    $response = ErrorResponse::create($e->getMessage(), 400);
} catch (Throwable $e) {
    $response = ErrorResponse::create($e->getMessage(), 500);
} finally {
    $response->prepare($request)->send();
}
