<?php

use App\Controller\OrdersApiController;
use App\Core\Bootstrap;
use App\Core\Router;

Router::addHandler(
    '/api/orders',
    'GET',
    fn(Bootstrap $app) => (new OrdersApiController($app))->getOrderStatus()
);

Router::addHandler(
    '/orders/calculate',
    'POST',
    fn(Bootstrap $app) => (new OrdersApiController($app))->calculateOrder()
);

Router::addHandler(
    '/api/orders',
    'POST',
    fn(Bootstrap $app) => (new OrdersApiController($app))->pushTask()
);

Router::addHandler(
    '/orders/tasks',
    'RUN',
    fn(Bootstrap $app) => (new OrdersApiController($app))->runTasks()
);