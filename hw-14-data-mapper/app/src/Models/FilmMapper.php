<?php

namespace App\Models;

use Exception;
use PDO;
use PDOStatement;

class FilmMapper
{
    /**
     * @var PDO
     */
    private PDO $pdo;

    /**
     * @var PDOStatement
     */
    private PDOStatement $selectStmt;

    /**
     * @var PDOStatement
     */
    private PDOStatement $insertStmt;

    /**
     * @var PDOStatement
     */
    private PDOStatement $updateStmt;

    /**
     * @var PDOStatement
     */
    private PDOStatement $deleteStmt;

    /**
     * FilmMapper constructor.
     *
     * @param PDO $pdo
     */
    public function __construct (PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "SELECT id, title, show_start_date, length FROM films where id = ?"
        );

        $this->insertStmt = $pdo->prepare(
            "INSERT INTO films (title, show_start_date, length) VALUES (?, ?, ?)"
        );

        $this->updateStmt = $pdo->prepare(
            "UPDATE films SET title = ?, show_start_date = ?, length = ? WHERE id = ?"
        );

        $this->deleteStmt = $pdo->prepare("DELETE FROM films WHERE id = ?");
    }

    /**
     * @param int $id
     *
     * @return null|Film
     */
    public function findById (int $id): ?Film
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        if (empty($result)) {
            return null;
        }

        $film = new Film(
            $id,
            $result['title'],
            $result['show_start_date'],
            $result['length'],
        );

        return $film;
    }

    /**
     * @param FilmDTO $filmDTO
     *
     * @return Film
     * @throws Exception
     */
    public function insert (FilmDTO $filmDTO): Film
    {
        $result = $this->insertStmt->execute(
            [
                $filmDTO->title,
                $filmDTO->showStartDate,
                $filmDTO->lenght,
            ]
        );

        if ($result !== true) {
            throw new Exception('film saving error');
        }

        $id = (int)$this->pdo->lastInsertId('films_pk');

        $film = new Film(
            $id,
            $filmDTO->title,
            $filmDTO->showStartDate,
            $filmDTO->lenght
        );

        return $film;
    }

    /**
     * @param Film $film
     *
     * @return bool
     */
    public function update (Film $film): bool
    {
        $result = $this->updateStmt->execute(
            [
                $film->getTitle(),
                $film->getShowStartDate(),
                $film->getLength(),
                $film->getId(),
            ]
        );

        return $result;
    }

    /**
     * @param Film $film
     *
     * @return bool
     */
    public function delete (Film $film): bool
    {
        return $this->deleteStmt->execute([$film->getId()]);
    }
}