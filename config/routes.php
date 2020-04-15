<?php

use Bjlag\Controllers;

return function (\League\Route\Router $router) {
    $router->map('GET', '/', [Controllers\SiteController::class, 'indexAction']);
    $router->map('GET', '/channels', [Controllers\ChannelController::class, 'indexAction']);
    $router->map('GET', '/channels/{id:slug}', [Controllers\ChannelController::class, 'viewAction']);
    $router->map('GET', '/videos', [Controllers\VideoController::class, 'indexAction']);

    $router->group('/api', function (\League\Route\RouteGroup $route) {
        $route->map('POST', '/channel/add', [Controllers\ChannelController::class, 'addAction']);
        $route->map('POST', '/channel/edit', [Controllers\ChannelController::class, 'editAction']);
        $route->map('POST', '/channel/delete', [Controllers\ChannelController::class, 'deleteAction']);

        $route->map('POST', '/video/add', [Controllers\VideoController::class, 'addAction']);
        $route->map('POST', '/video/edit', [Controllers\VideoController::class, 'editAction']);
        $route->map('POST', '/video/delete', [Controllers\VideoController::class, 'deleteAction']);
    });
};
