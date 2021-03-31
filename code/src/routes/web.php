<?php

use Slim\App;

return function (App $app) {
    $app->get('/', 'App\Controller\HomeController:index');

    $app->map(['GET', 'POST'], '/validation', 'App\Controller\ValidationController:index');

    $app->get('/channels', 'App\Controller\ChannelController:index');
    $app->get('/channels/top', 'App\Controller\ChannelController:top');
    $app->get('/channels/{id}', 'App\Controller\ChannelController:show');

    $app->get('/event', 'App\Controller\EventController:index');

    $app->post('/api/event', 'App\Controller\EventController:event');
    $app->get('/api/events', 'App\Controller\EventController:events');
    $app->post('/api/events', 'App\Controller\EventController:createEvent');
    $app->delete('/api/events', 'App\Controller\EventController:drop');

    $app->get('/airlines', 'App\Controller\AirlineController:index');
    $app->get('/airlines/{id}', 'App\Controller\AirlineController:show');
};
