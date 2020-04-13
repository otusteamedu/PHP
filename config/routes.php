<?php

use Bjlag\Controllers;

return function (\League\Route\Router $router) {
    $router->map('GET', '/', [Controllers\SiteController::class, 'indexAction']);
    $router->map('GET', '/channels', [Controllers\ChannelController::class, 'indexAction']);

    $router->group('/api', function (\League\Route\RouteGroup $route) {
        $route->map('POST', '/channel/add', [Controllers\ChannelController::class, 'addAction']);
        $route->map('POST', '/channel/edit', [Controllers\ChannelController::class, 'editAction']);
    });
};
