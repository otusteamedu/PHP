<?php

namespace Entity;

use Entity\Filter\IFilters;
use Entity\Filter\GenresFilter;
use Entity\Filter\MoviesFilter;
use PDO;

class Movie extends Entity
{
    private string $title = '';
    private int $duration = 0;

    /**
     * @var Genre[]
     */
    private array $genres = [];

    /**
     * @param PDO $pdo
     * @param int $id
     * @return Movie
     */
    public static function getById(PDO $pdo, int $id): Movie
    {
        return self::getByFilter($pdo, new MoviesFilter($id))[0] ??
               new static();
    }

    /**
     * @param PDO      $pdo
     * @param IFilters $filter
     * @return Movie[]
     */
    public static function getByFilter(PDO $pdo, IFilters $filter): array
    {
        $st = $pdo->prepare(
            'select id, title, duration from movies where (id = :id or :id = \'\') 
                                         and (title = :title or :title = \'\') 
                                         and (duration <= :duration_max or :duration_max = \'\' ) 
                                         and (duration >= :duration_min or :duration_min = \'\') 
                                         and (id in (select movie_id from movies_genres where genre_id = :genre_id) or :genre_id = \'\');'
        );
        if ($st->execute($filter->fetch())) {
            return array_map(
                fn(array $row) => (new static($pdo))->build($row),
                $st->fetchAll()
            );
        }
        return [];
    }

    /**
     * @return array
     */
    public function fetchArray(): array
    {
        return [
            'id'       => $this->getId(),
            'title'    => $this->title,
            'duration' => $this->duration,
            'genres'   => array_map(
                fn(Genre $genre) => $genre->fetchArray(),
                $this->genres
            ),
        ];
    }

    /**
     * @param array $row
     * @return Movie
     */
    public function build(array $row): Movie
    {
        return (new Movie())->setId(intval($row['id']))->setTitle(
            $row['title']
        )->setDuration(intval($row['duration']))->setGenres(
            Genre::getByFilter(
                $this->pdo,
                (new GenresFilter())->setMovieId(intval($row['id']))
            )
        );
    }

    /**
     * @return bool
     */
    public function create(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Movie
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     * @return Movie
     */
    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return Genre[]
     */
    public function getGenres(): array
    {
        return $this->genres;
    }

    /**
     * @param Genre[] $genres
     * @return Movie
     */
    public function setGenres(array $genres): self
    {
        $this->genres = $genres;
        return $this;
    }
}