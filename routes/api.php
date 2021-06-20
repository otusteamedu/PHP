<?php
/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Api\OrderController;
use Laravel\Lumen\Routing\Router;


$router->group(['prefix' => 'orders'], static function (Router $router) {
    $router->post('/', OrderController::class . '@add');
    $router->get('/{id}', OrderController::class . '@get');
});