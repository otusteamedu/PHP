<?php

use Otus\Http\Controllers\IndexController;

require '../vendor/autoload.php';

$controller = new IndexController();

$urlParts = parse_url($_SERVER['REQUEST_URI']);

$path = $urlParts['path'];

if ($path === '/') {
    $controller->index();
    return;
}

http_response_code(404);
echo 'Указанная страница не найдена';
