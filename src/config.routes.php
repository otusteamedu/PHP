<?php

use App\Core\Router;

Router::addHandler(
    '/',
    'GET',
    fn($app) => (new App\Controller\FilmsController($app))->showPage(
        __DIR__ . '/views/pages/index.html'
    )
);
Router::addHandler(
    '/films',
    'GET',
    fn($app) => (new App\Controller\FilmsController($app))->getFilms()
);
Router::addHandler(
    '/films',
    'POST',
    fn($app) => (new App\Controller\FilmsController($app))->createFilm()
);
Router::addHandler(
    '/genres',
    'GET',
    fn($app) => (new App\Controller\GenresController($app))->getGenres()
);
Router::addHandler(
    '/genres',
    'POST',
    fn($app) => (new App\Controller\GenresController($app))->createGenre()
);