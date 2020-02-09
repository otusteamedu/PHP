<?php

namespace Controller;

use Entity\Filter\MoviesFilter;
use Entity\Movie;

class FilmsController extends AppController
{
    public function getFilms()
    {
        $movies = array_map(
            fn(Movie $movie): array => $movie->fetchArray(),
            Movie::getByFilter($this->app->getPdo(), new MoviesFilter())
        );
        $this->app->getResponse()->setBody(
            json_encode($movies, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    public function getFilmById()
    {
        $this->getApp()->getResponse()->setBody(
            json_encode(
                Movie::getById($this->app->getPdo(), intval($_GET['id']))
            )
        );
    }
}