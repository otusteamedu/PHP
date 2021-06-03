<?php


use Slim\App;
use Slim\Routing\RouteCollectorProxy;


const NAMESPACE_CONTROLLER_V1 = 'App\Controller\Api\v1\\';


return function (App $app) {

    $app->group('/api/v1', function (RouteCollectorProxy $v1Group) {

        $v1Group->get('/users', NAMESPACE_CONTROLLER_V1 .'UserController:usersAction');

        $v1Group->group('/airlines', function (RouteCollectorProxy $airlinesGroup) {
            $controller = NAMESPACE_CONTROLLER_V1 . 'AirlineController';

            $airlinesGroup->get('', $controller . ':index');
            $airlinesGroup->post('', $controller . ':create');
            $airlinesGroup->get('/{id}', $controller . ':read');
            $airlinesGroup->put('', $controller . ':update');
            $airlinesGroup->delete('/{id}', $controller . ':delete');
        });


        $v1Group->post('/login', NAMESPACE_CONTROLLER_V1 . 'SecurityController:login');
    });



};

