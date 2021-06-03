<?php


use Slim\App;
use Slim\Routing\RouteCollectorProxy;


const PREFIX_CONTROLLER_V1 = 'App\Controller\Api\v1\\';

return function (App $app) {

    $app->group('/api/v1', function (RouteCollectorProxy $group) {

        $group->get('/users', PREFIX_CONTROLLER_V1 .'UserController:usersAction');

        $group->post('/login', PREFIX_CONTROLLER_V1 . 'SecurityController:login');
    });



};

