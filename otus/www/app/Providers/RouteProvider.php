<?php

namespace App\Providers;

use Slim\App;

class RouteProvider
{
    public function register(App $app): void
    {
        
        $app->post('/order/create', 'App\Controllers\OrderController:createOrder');
        $app->post('/order/delete', 'App\Controllers\OrderController:deleteOrder');
        $app->get('/order/product-list', 'App\Controllers\OrderController:getProductList');
        $app->get('/order-types/list', 'App\Controllers\OrderController:getOrderTypesList');

        $app->get('/delivery-service/list', 'App\Controllers\DeliveryController:getList');
        $app->get('/delivery-types/list', 'App\Controllers\DeliveryController:getDeliveryTypesList');

        $app->get('/clients/orders-list', 'ClientController:getClientOrderList');

    }
}
