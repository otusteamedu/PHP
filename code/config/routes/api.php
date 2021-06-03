<?php


use App\Middleware\AuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;


const NAMESPACE_CONTROLLER_V1 = 'App\Controller\Api\v1\\';


return function (App $app) {

    $app->group('/api/v1', function (RouteCollectorProxy $v1Group) use ($app) {

        $v1Group->get('/users', NAMESPACE_CONTROLLER_V1 .'UserController:usersAction');

        $v1Group->group('/airlines', function (RouteCollectorProxy $airlinesGroup) use ($app) {
            $controller = NAMESPACE_CONTROLLER_V1 . 'AirlineController';

            $airlinesGroup->get('', $controller . ':index');
            $airlinesGroup->post('', $controller . ':create');
            $airlinesGroup->get('/{id}', $controller . ':read');
            $airlinesGroup->put('', $controller . ':update');
            $airlinesGroup->delete('/{id}', $controller . ':delete');

        })->add($app->getContainer()->get(AuthMiddleware::class));


        $v1Group->post('/login', NAMESPACE_CONTROLLER_V1 . 'SecurityController:login');
    });



};

