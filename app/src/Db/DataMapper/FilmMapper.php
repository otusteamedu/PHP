<?php

namespace App\Db\DataMapper;

use App\Db\Connect;
use PDO;
use PDOStatement;

/**
 * Class FilmMapper
 * @package App\Db\DataMapper
 */
class FilmMapper
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var Connect
     */
    private $connect;

    /**
     * @var PDOStatement|bool
     */
    private $selectStmt;

    /**
     * @var PDOStatement|bool
     */
    private $insertStmt;

    /**
     * @var PDOStatement|bool
     */
    private $updateStmt;

    /**
     * @var PDOStatement|bool
     */
    private $deleteStmt;

    /**
     * ActiveRecord constructor.
     * @param Connect $connect
     */
    public function __construct(Connect $connect)
    {
        $this->connect = $connect;
        $this->pdo = $connect->getPdo();

        $this->selectStmt = $this->pdo->prepare(
            'SELECT name FROM film WHERE id = ?'
        );

        $this->insertStmt = $this->pdo->prepare(
            'INSERT INTO film (name) VALUES (?)'
        );

        $this->updateStmt = $this->pdo->prepare(
            'UPDATE film SET name = ? WHERE id = ?'
        );

        $this->deleteStmt = $this->pdo->prepare(
            'DELETE FROM film WHERE id = ?'
        );
    }

    /**
     * @param int $id
     * @return Film
     */
    public function findById(int $id): Film
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        $film = new Film(
            $result['name'],
        );

        $film->setId($id);

        return $film;
    }

    /**
     * @param array $raw
     * @return Film
     */
    public function insert(array $raw): Film
    {
        $this->insertStmt->execute([
            $raw['name'],
        ]);

        $film = new Film($raw['name']);
        $film->setId((int)$this->pdo->lastInsertId());

        return $film;
    }

    /**
     * @return bool
     */
    public function update(Film $film): bool
    {
        return $this->updateStmt->execute([
            $film->getName(),
            $film->getId()
        ]);
    }

    /**
     * @return bool
     */
    public function delete(Film $film): bool
    {
        return $this->deleteStmt->execute([$film->getId()]);
    }
}