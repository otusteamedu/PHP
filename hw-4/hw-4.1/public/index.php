<?php

require __DIR__ . '/../bootstrap.php';

$urlParts = parse_url($_SERVER['REQUEST_URI']);

$path = $urlParts['path'];

if ($path === '/') {
    $controller = new App\Http\Controllers\IndexController();
    $controller->index();
    return;
}

http_response_code(404);
