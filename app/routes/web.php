<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/user-requests/show', 'UserRequestController@show');
$router->post('/user-requests', 'UserRequestController@store');


