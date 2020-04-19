<?php

use Bjlag\Controllers;

return function (\League\Route\Router $router) {
    $router->map('GET', '/', [Controllers\SiteController::class, 'indexAction']);

    $router->group('/api', function (\League\Route\RouteGroup $route) {
        $route->map('POST', '/events', [Controllers\EventController::class, 'indexAction']);
        $route->map('POST', '/event/add', [Controllers\EventController::class, 'addAction']);
        $route->map('POST', '/event/remove', [Controllers\EventController::class, 'removeOneAction']);
        $route->map('POST', '/event/clear', [Controllers\EventController::class, 'removeAllAction']);

        $route->map('POST', '/request', [Controllers\RequestController::class, 'findEventAction']);
    });
};
