<?php

namespace App\Entity\Filter;

class MoviesFilter extends EntityFilter
{
    public const TITLE = 'title';
    public const DURATION_MIN = 'duration_min';
    public const DURATION_MAX = 'duration_max';
    public const GENRE_ID = 'genre_id';

    private string $title = '';
    private string $durationMin = '';
    private string $durationMax = '';
    private string $genreId = '';

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return MoviesFilter
     */
    public function setTitle(string $title): MoviesFilter
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDurationMin(): string
    {
        return $this->durationMin;
    }

    /**
     * @param string $durationMin
     * @return MoviesFilter
     */
    public function setDurationMin(string $durationMin): MoviesFilter
    {
        $this->durationMin = $durationMin;
        return $this;
    }

    /**
     * @return string
     */
    public function getDurationMax(): string
    {
        return $this->durationMax;
    }

    /**
     * @param string $durationMax
     * @return MoviesFilter
     */
    public function setDurationMax(string $durationMax): MoviesFilter
    {
        $this->durationMax = $durationMax;
        return $this;
    }

    /**
     * @return string
     */
    public function getGenreId(): string
    {
        return $this->genreId;
    }

    /**
     * @param string $genreId
     * @return MoviesFilter
     */
    public function setGenreId(string $genreId): MoviesFilter
    {
        $this->genreId = $genreId;
        return $this;
    }
}