<?php

use Framework\App;
use Framework\Middleware\RouteMatcherMiddleware;
use Framework\Router\AuraRouterAdapter;
use Framework\Router\HandlerResolver;
use Laminas\Diactoros\Response;
use Laminas\Stratigility\Middleware\NotFoundHandler;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

(function () {
    $routes = (require 'config/routes.php')();
    $router = new AuraRouterAdapter($routes);
    $app = new App();

    $app->pipe(new RouteMatcherMiddleware($router, new HandlerResolver()));
    $app->pipe(new NotFoundHandler(function () {
        return new Response();
    }));

    $app->run();
})();
