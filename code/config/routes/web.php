<?php

use Slim\App;

return function (App $app) {
    $app->get('/', 'App\Controller\HomeController:index');
    $app->map(['GET', 'POST'], '/login', 'App\Controller\SecurityController:login');
    $app->get('/logout', 'App\Controller\SecurityController:logout');
};
