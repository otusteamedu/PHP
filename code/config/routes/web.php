<?php

use App\Controller\ApidocController;
use App\Middleware\SecurityMiddleware;
use App\Service\Security\SecurityInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $securityService = $app
        ->getContainer()
        ->get(SecurityInterface::class);

    $app->get('/', 'App\Controller\HomeController:index');
    $app->map(['GET', 'POST'], '/login', 'App\Controller\SecurityController:login');
    $app->get('/logout', 'App\Controller\SecurityController:logout');

    $app->group('/', function (RouteCollectorProxy $group) {
        $group->map(['GET', 'POST'], 'bank-operation', 'App\Controller\UserController:bankAccount');
        $group->get('profile', 'App\Controller\UserController:profile');
    })->add(new SecurityMiddleware($securityService));

    $app->get('/api/doc', ApidocController::class);
};
