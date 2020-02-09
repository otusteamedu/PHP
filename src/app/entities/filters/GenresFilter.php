<?php

namespace Entity\Filter;

class GenresFilter extends EntityFilter
{
    public const MOVIE_ID = 'movie_id';

    private string $movieId = '';

    /**
     * @return string
     */
    public function getMovieId(): string
    {
        return $this->movieId;
    }

    /**
     * @param string $movieId
     * @return GenresFilter
     */
    public function setMovieId(string $movieId): GenresFilter
    {
        $this->movieId = $movieId;
        return $this;
    }
}