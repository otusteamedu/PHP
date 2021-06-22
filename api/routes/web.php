<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api/v1', 'namespace' => 'Api\Orders'], function () use ($router) {
    $router->get('/orders', ['uses' => 'GetOrdersController']);
    $router->get('/orders/{orderId}', ['uses' => 'ShowOrdersController', 'as' => 'orders.show']);
    $router->post('/orders', ['uses' => 'StoreOrdersController', 'as' => 'orders.store']);
    $router->put('/orders/{orderId}', ['uses' => 'UpdateOrdersController']);
    $router->delete('/orders/{orderId}', ['uses' => 'DeleteOrdersController']);
});
$router->get('/check-status', ['uses' => 'OrderController@checkStatus']);
$router->get('/create-order', ['uses' => 'OrderController@create']);
$router->post('/create', ['uses' => 'OrderController@createOrder']);
