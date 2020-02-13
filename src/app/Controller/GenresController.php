<?php

namespace App\Controller;

use App\Core\AppException;
use App\Entity\Filter\GenresFilter;
use App\Entity\Genre;

class GenresController extends JsonAppController
{
    public function getGenres()
    {
        $genres = array_map(
            fn(Genre $genre): array => $genre->fetchArray(),
            Genre::getByFilter($this->app->getPdo(), new GenresFilter())
        );
        $this->app->getResponse()->setBody(
            json_encode($genres, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    /**
     * @throws AppException
     */
    public function createGenre()
    {
        $genre = new Genre($this->app->getPdo());
        $success = $genre->setName($_POST['name'])->create();
        if ($success) {
            $this->app->getResponse()->setBody(
                json_encode(
                    $genre->fetchArray(),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                )
            );
        } else {
            throw new AppException('could not create genre');
        }
    }
}