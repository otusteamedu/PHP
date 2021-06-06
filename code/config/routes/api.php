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
use App\Controller\Api\v1\FlightSchedule\FlightByDateController;
use App\Controller\Api\v1\FlightSchedule\FlightCreateController;
use App\Controller\Api\v1\FlightSchedule\FlightDeleteController;
use App\Controller\Api\v1\FlightSchedule\FlightIndexController;
use App\Controller\Api\v1\Request\RequestController;
use App\Controller\Api\v1\SecurityController;
use App\Middleware\AuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;


return function (App $app) {

    $app->group('/api/v1', function (RouteCollectorProxy $v1Group) use ($app) {

        $authMiddleware = $app->getContainer()->get(AuthMiddleware::class);

        $v1Group->group('/airlines', function (RouteCollectorProxy $airlinesGroup) {
            $airlinesGroup->get('', AirlineIndexController::class);
            $airlinesGroup->post('', AirlineCreateController::class);
            $airlinesGroup->get('/{id:[0-9]+}', AirlineReadController::class);
            $airlinesGroup->put('', AirlineUpdateController::class);
            $airlinesGroup->delete('/{id:[0-9]+}', AirlineDeleteController::class);
        })->add($authMiddleware);

        $v1Group->group('/cities', function (RouteCollectorProxy $citiesGroup) {
            $citiesGroup->get('', CityIndexController::class);
            $citiesGroup->post('', CityCreateController::class);
            $citiesGroup->get('/{id:[0-9]+}', CityReadController::class);
            $citiesGroup->put('', CityUpdateController::class);
            $citiesGroup->delete('/{id:[0-9]+}', CityDeleteController::class);
        })->add($authMiddleware);

        $v1Group->group('/flights', function (RouteCollectorProxy $flightsGroup) {
            $flightsGroup->get('', FlightIndexController::class);
            $flightsGroup->get('/{date:[0-9]{4}-[0-9]{2}-[0-9]{2}}', FlightByDateController::class);
            $flightsGroup->post('', FlightCreateController::class);
            $flightsGroup->delete('/{id:[0-9]+}', FlightDeleteController::class);
        })->add($authMiddleware);

        $v1Group->get('/request-status/{request_number:[0-9]+}', RequestController::class)
            ->add($authMiddleware);

        $v1Group->post('/login', SecurityController::class .':login');
    });
};

