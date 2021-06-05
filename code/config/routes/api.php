<?php


use App\Controller\Api\v1\Airline\AirlineCreateController;
use App\Controller\Api\v1\Airline\AirlineDeleteController;
use App\Controller\Api\v1\Airline\AirlineIndexController;
use App\Controller\Api\v1\Airline\AirlineReadController;
use App\Controller\Api\v1\Airline\AirlineUpdateController;
use App\Controller\Api\v1\City\CityCreateController;
use App\Controller\Api\v1\City\CityDeleteController;
use App\Controller\Api\v1\City\CityIndexController;
use App\Controller\Api\v1\City\CityReadController;
use App\Controller\Api\v1\City\CityUpdateController;
use App\Controller\Api\v1\SecurityController;
use App\Middleware\AuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;


return function (App $app) {

    $app->group('/api/v1', function (RouteCollectorProxy $v1Group) use ($app) {

        $v1Group->group('/airlines', function (RouteCollectorProxy $airlinesGroup) {
            $airlinesGroup->get('', AirlineIndexController::class);
            $airlinesGroup->post('', AirlineCreateController::class);
            $airlinesGroup->get('/{id}', AirlineReadController::class);
            $airlinesGroup->put('', AirlineUpdateController::class);
            $airlinesGroup->delete('/{id}', AirlineDeleteController::class);
        })->add($app->getContainer()->get(AuthMiddleware::class));

        $v1Group->group('/cities', function (RouteCollectorProxy $citiesGroup) {
            $citiesGroup->get('', CityIndexController::class);
            $citiesGroup->post('', CityCreateController::class);
            $citiesGroup->get('/{id}', CityReadController::class);
            $citiesGroup->put('', CityUpdateController::class);
            $citiesGroup->delete('/{id}', CityDeleteController::class);
        })->add($app->getContainer()->get(AuthMiddleware::class));

        $v1Group->post('/login', SecurityController::class .':login');
    });
};

