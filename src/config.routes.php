<?php

use App\Controller\AppController;
use App\Controller\OrdersController;
use App\Core\Bootstrap;
use App\Core\Router;

Router::addHandler(
    '/',
    'GET',
    fn() => AppController::showPage(__DIR__ . '/App/views/index.html')
)->setContentType(\App\Core\ClientResponse::CONTENT_TYPE_HTML);

Router::addHandler(
    '/products',
    'GET',
    fn(Bootstrap $app) => (new OrdersController($app))->getProducts()
);

Router::addHandler(
    '/products',
    'GET',
    fn(Bootstrap $app) => (new OrdersController($app))->getProducts()
);

Router::addHandler(
    '/discounts',
    'GET',
    fn(Bootstrap $app) => (new OrdersController($app))->getDiscounts()
);

Router::addHandler(
    '/deliveries',
    'GET',
    fn(Bootstrap $app) => (new OrdersController($app))->getDeliveryServices()
);

Router::addHandler(
    '/clients',
    'GET',
    fn(Bootstrap $app) => (new OrdersController($app))->getClients()
);

Router::addHandler(
    '/orders',
    'GET',
    fn(Bootstrap $app) => (new OrdersController($app))->getOrders()
);

Router::addHandler(
    '/orders/example/1',
    'GET',
    fn(Bootstrap $app) => (new \App\Controller\OrdersExample1Controller($app))->showExample()
);
Router::addHandler(
    '/orders/example/2',
    'GET',
    fn(Bootstrap $app) => (new \App\Controller\OrdersExample2Controller($app))->showExample()
);