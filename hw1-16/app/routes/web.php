<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1', 'namespace' => 'Api'], function () use ($router) {
    $router->get('/tasks', ['uses' => 'GetTasksController']);
    $router->get('/tasks/{taskId}', ['uses' => 'ShowTasksController']);
    $router->put('/tasks/{taskId}', ['uses' => 'UpdateTasksController']);
    $router->post('/tasks', ['uses' => 'StoreTasksController']);
    $router->delete('/tasks/{taskId}', ['uses' => 'DeleteTasksController']);
    $router->get('/tasks/check-status/{taskId}', ['uses' => 'GetTaskStatusController']);
});
