<?php

require __DIR__.'/../bootstrap/autoload.php';

use Otus\Http\Controller;
use Otus\Http\Request;
use Otus\Http\Router;

$router = new Router();
$router->addRoute('POST', '/', [Controller::class, 'index']);

$request  = Request::capture();
$response = $router->handle($request);

$response->send();
