<?php

use App\Middleware\ErrorHandlerMiddleware;
use Framework\App;
use Framework\Middleware\RouteMatcherMiddleware;

return function (App $app) {
    $app->pipe(ErrorHandlerMiddleware::class);
    $app->pipe(RouteMatcherMiddleware::class);
};
