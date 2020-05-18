<?php

use Framework\App;
use Framework\Middleware\RouteMatcherMiddleware;
use Laminas\Stratigility\Middleware\NotFoundHandler;

return function (App $app) {
    $app->pipe(RouteMatcherMiddleware::class);
    $app->pipe(NotFoundHandler::class);
};
