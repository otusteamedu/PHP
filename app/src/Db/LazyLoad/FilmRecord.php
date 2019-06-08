<?php

namespace App\Db\LazyLoad;

use App\Db\Connect;
use DateTime;
use Exception;
use PDO;
use PDOStatement;

/**
 * Class FilmRecord
 * @package App\Db\LazyLoad
 */
class FilmRecord
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
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

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
     * FilmRecord constructor.
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return SeanceRecord
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return FilmRecord
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $id
     * @return FilmRecord
     */
    public function findById(int $id): self
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return (new self($this->connect))
            ->setId($id)
            ->setName($result['name']);
    }

     /**
     * @return int
     */
    public function insert(): bool
    {
        $result = $this->insertStmt->execute([
            $this->getName(),
        ]);

        $this->setId($this->pdo->lastInsertId());

        return $result;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->getName(),
            $this->getId()
        ]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $result = $this->deleteStmt->execute([$this->getId()]);
        $this->setId(null);

        return $result;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getId() . ', ' . $this->getName();
    }
}