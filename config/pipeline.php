<?php

use App\Middleware\ErrorHandlerMiddleware;
use App\Middleware\JsonParsedMiddleware;
use Framework\App;
use Framework\Middleware\RouteMatcherMiddleware;

return function (App $app) {
    $app->pipe(ErrorHandlerMiddleware::class);
    $app->pipe(JsonParsedMiddleware::class);
    $app->pipe(RouteMatcherMiddleware::class);
};
