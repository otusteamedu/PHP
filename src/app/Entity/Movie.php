<?php

namespace App\Entity;

use App\Entity\Filter\GenresFilter;
use App\Entity\Filter\MoviesFilter;
use PDO;
use PDOStatement;

class Movie extends Entity
{
    private string $title = '';
    private int $duration = 0;

    /**
     * @var Genre[]
     */
    private array $genres = [];

    private PDOStatement $createStatement;
    private PDOStatement $deleteStatement;
    private PDOStatement $updateStatement;

    protected static string
        $selectQuery = 'select id, title, duration from cinema.movies where (id = :id or :id = \'\') 
            and (title = :title or :title = \'\') 
            and (duration <= :duration_max or :duration_max = \'\' ) 
            and (duration >= :duration_min or :duration_min = \'\') 
            and (id in (select movie_id from cinema.movies_genres where genre_id = :genre_id) or :genre_id = \'\');';

    /**
     * Movie constructor.
     * @param PDO|null $pdo
     */
    public function __construct(?PDO $pdo = null)
    {
        parent::__construct($pdo);
        if ($pdo instanceof PDO) {
            $this->createStatement = $pdo->prepare(
                'insert into movies (title, duration) values (?, ?);'
            );
            $this->updateStatement = $pdo->prepare(
                'update movies set title = ?, duration = ? where id = ?;'
            );
            $this->deleteStatement = $pdo->prepare(
                'delete from movies where id = ?;'
            );
        }
    }

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
     * @param PDO   $pdo
     * @return Movie
     */
    public static function initByRow(PDO $pdo, array $row): Entity
    {
        return static::getCache($row['id']) ?? static::putCache(
                (new static())->setId($row['id'])
                              ->setTitle($row['title'])
                              ->setDuration($row['duration'])
                              ->setGenres(
                                  Genre::getByFilter(
                                      $pdo,
                                      (new GenresFilter())->setMovieId(
                                          intval($row['id'])
                                      )
                                  )
                              )
            );
    }

    /**
     * @return bool
     */
    public function create(): bool
    {
        if ($this->createStatement->execute([$this->title, $this->duration])) {
            self::putCache($this->setId($this->pdo->lastInsertId()));
            if (!empty($this->genres)) {
                return $this->pdo->query(
                        'insert into movies_genres (movie_id, genre_id) values '
                        . implode(
                            ',',
                            array_map(
                                fn(Genre $genre) => '(' . $this->getId() . ','
                                                    . $genre->getId() . ')',
                                $this->genres
                            )
                        ) . ';'
                    ) instanceof PDOStatement;
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return self::putCache($this)->updateStatement->execute(
            [$this->title, $this->duration, $this->getId()]
        );
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return self::popCache($this)->deleteStatement->execute(
            [$this->getId()]
        );
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