<?php

namespace App\Controller;

use App\Core\AppException;
use App\Entity\Filter\MoviesFilter;
use App\Entity\Genre;
use App\Entity\Movie;

class FilmsController extends JsonAppController
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

    public function showPage(string $pageFile)
    {
        parent::showPage($pageFile);
    }

    /**
     * @throws AppException
     */
    public function createFilm()
    {
        $movie = new Movie($this->app->getPdo());
        $success = $movie->setTitle($_POST['title'])->setDuration(
            intval($_POST['duration'])
        )->setGenres(
            array_map(
                fn($id) => Genre::getById($this->app->getPdo(), intval($id)),
                $_POST['genre_id']
            )
        )->create();
        if ($success) {
            $this->app->getResponse()->setBody(
                json_encode(
                    $movie->fetchArray(),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                )
            );
        } else {
            throw new AppException('could not create film');
        }
    }
}