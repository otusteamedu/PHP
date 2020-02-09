<?php

use Controller\FilmsController;
use Core\Handler;

(new Handler(
    '/',
    'GET',
    fn($app) => FilmsController::showPage(__DIR__ . '/app/views/index.html')
))();

(new Handler(
    '/films', 'GET', fn($app) => (new FilmsController($app))->getFilms()
))();

(new Handler(
    '/films', 'POST', fn($app) => (new FilmsController($app))->create()
))();

(new Handler(
    '/films/update', 'POST', fn($app) => (new FilmsController($app))->update()
))();

(new Handler(
    '/films', 'UPDATE', fn($app) => (new FilmsController($app))->update()
))();

(new Handler(
    '/films', 'UPDATE', fn($app) => (new FilmsController($app))->update()
))();