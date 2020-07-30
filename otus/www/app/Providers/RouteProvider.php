<?php

namespace App\Providers;

use Slim\App;

class RouteProvider
{
    public function register(App $app): void
    {
        $app->post('/order/create', 'App\Controllers\OrderController:createOrder');

        $app->post('/message/push', 'App\Controllers\PublisherController:push');
        $app->post('/message/status', 'App\Controllers\PublisherController:getStatus');

        $app->get('/request/run', 'App\Controllers\SubscriberController:run');
    }
}
