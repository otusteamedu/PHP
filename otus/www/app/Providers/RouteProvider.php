<?php

namespace App\Providers;

use Slim\App;

class RouteProvider
{
    public function register(App $app): void
    {
        $app->post('/order/create', 'App\Controllers\OrderController:createOrder');
    }
}
