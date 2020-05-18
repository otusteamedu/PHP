<?php

use Framework\App;
use Framework\Middleware\RouteMatcherMiddleware;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Psr\Container\ContainerInterface;

return function (App $app, ContainerInterface $container) {
    $app->pipe($container->get(RouteMatcherMiddleware::class));
    $app->pipe($container->get(NotFoundHandler::class));
};
