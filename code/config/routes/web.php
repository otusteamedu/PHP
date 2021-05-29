<?php

use App\Middleware\SecurityMiddleware;
use App\Service\Security\SecurityInterface;
use Slim\App;

return function (App $app) {
    $securityService = $app->getContainer()
        ->get(SecurityInterface::class);

    $app->get('/', 'App\Controller\HomeController:index');
    $app->map(['GET', 'POST'], '/login', 'App\Controller\SecurityController:login');
    $app->get('/logout', 'App\Controller\SecurityController:logout');
    $app->map(['GET', 'POST'], '/bank-account', 'App\Controller\UserController:bankAccount')
        ->add(new SecurityMiddleware($securityService));
};
