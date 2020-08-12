<?php

namespace Models\Movies;

use Contracts\MovieStorageInterface;
use Models\Movies\Movie;
use \PDO;

class MovieMapper implements MovieStorageInterface
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var PDOStatement
     */
    private $insertStmt;

    /**
     * @var PDOStatement
     */
    private $selectStmt;

    /**
     * @var PDOStatement
     */
    private $updateStmt;

    /**
     * @var PDOStatement
     */
    private $deleteStmt;

    /**
     * MovieMapper constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "SELECT name, creation_date, trailer, image_folder, description, duration, censor
            FROM movies WHERE id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "INSERT INTO movies (name, creation_date, trailer, image_folder, description, duration, censor) 
            values (?, ?, ?, ?, ?, ?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "UPDATE movies SET name = ?, creation_date = ?, trailer = ?, image_folder = ?, description = ?, duration = ?, censor = ? 
            WHERE id = ?"
        );
        $this->deleteStmt = $pdo->prepare(
            "DELETE FROM movies WHERE id = ?"
        );
    }

    /**
     * @param Movie $movie
     * @return Movie
     */
    public function insert(Movie $movie): Movie
    {
        $this->insertStmt->execute([
            $movie->getName(),
            $movie->getCreationDate(),
            $movie->getTrailer(),
            $movie->getImageFolder(),
            $movie->getDescription(),
            $movie->getDuration(),
            $movie->getCensor()
        ]);

        return new Movie(
            (int) $this->pdo->lastInsertId(),
            $movie->getName(),
            $movie->getCreationDate(),
            $movie->getTrailer(),
            $movie->getImageFolder(),
            $movie->getDescription(),
            $movie->getDuration(),
            $movie->getCensor()
        );
    }

    /**
     * @param int $id
     * @return Movie
     */
    public function select(int $id): Movie
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new Movie(
            $id,
            $result['name'],
            $result['creation_date'],
            $result['trailer'],
            $result['image_folder'],
            $result['description'],
            $result['duration'],
            $result['censor']
        );
    }

    /**
     * @param Movie $movie
     * @return bool
     */
    public function update(Movie $movie): bool
    {

        return $this->updateStmt->execute([
            $movie->getName(),
            $movie->getCreationDate(),
            $movie->getTrailer(),
            $movie->getImageFolder(),
            $movie->getDescription(),
            $movie->getDuration(),
            $movie->getCensor(),
            $movie->getId()
        ]);

    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->deleteStmt->execute([$id]);
    }

    /**
     * Функция возвращает строки с фильмами в пределах заданных дат выхода фильма
     * @param string    $from   от какой даты ищем
     * @param string    $to     до какой даты искать
     * @param int|null  $limit  (optional) ограничение на вывод
     * @return array
     */
    public function getRangeMoviesByCreationDate(string $from, string $to, ?int $limit = null): array
    {
        if ($limit) $limitString = " LIMIT ?";

        $statementQuery = sprintf(
            "SELECT id, name, creation_date, trailer, image_folder, description, duration, censor
            FROM movies 
            WHERE creation_date BETWEEN ? AND ? %s", $limitString
        );

        $statement = $this->pdo->prepare($statementQuery);
        $statement->setFetchMode(PDO::FETCH_ASSOC);

        if ($limit) $statement->execute([$from, $to, $limit]);
        else $statement->execute([$from, $to]);

        return $statement->fetchAll();
    }
}