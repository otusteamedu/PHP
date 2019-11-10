<?php

declare(strict_types=1);

namespace RowDataGateway\Gateways;

use PDO;
use PDOStatement;

class FilmGateway extends AbstractGateway
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $title;
    /**
     * @var int
     */
    public $year;
    /**
     * @var PDOStatement
     */
    protected $attachGenreStmt;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);

        $this->insertStmt = $this->pdo->prepare('insert into films (title, year) values (:title, :year)');
        $this->updateStmt = $this->pdo->prepare('update films set title=:title, year=:year where id=:id');
        $this->deleteStmt = $this->pdo->prepare('delete from films where id=:id');
        $this->attachGenreStmt = $this->pdo->prepare(
            'insert into films_has_genres (film_id, genre_id) values (:film_id, :genre_id)'
        );
    }

    /**
     * @return int
     */
    public function insert(): int
    {
        $this->insertStmt->execute([
            'title' => $this->title,
            'year' => $this->year,
        ]);
        $this->id = $this->pdo->lastInsertId();

        return (int)$this->id;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStmt->execute([
            'id' => $this->id,
            'title' => $this->title,
            'year' => $this->year,
        ]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $result = $this->deleteStmt->execute(['id' => $this->id]);

        $this->id = null;

        return $result;
    }

    /**
     * @param int $genreId
     * @return bool
     */
    public function attachGenre(int $genreId): bool
    {
        return $this->attachGenreStmt->execute(['film_id' => $this->id, 'genre_id' => $genreId]);
    }
}
