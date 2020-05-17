<?php

use Framework\App;
use Framework\Middleware\RouteMatcherMiddleware;
use Framework\Router\HandlerResolver;
use Framework\Router\Router;
use Laminas\Diactoros\Response;
use Laminas\Stratigility\Middleware\NotFoundHandler;

return function (App $app, Router $router) {
    $app->pipe(new RouteMatcherMiddleware($router, new HandlerResolver()));
    $app->pipe(new NotFoundHandler(function () {
        return new Response();
    }));
};
