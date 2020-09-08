<?php


use Otus\Http\Controller;
use Otus\Http\Request;
use Otus\Http\Router;
require __DIR__.'/../vendor/autoload.php';

$router = new Router();
$router->handle()->send();
