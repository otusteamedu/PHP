<?php

namespace App\Db\RowGateway;

use App\Db\Connect;
use DateTime;
use PDO;
use PDOStatement;

/**
 * Class RowGateway
 * @package App\Db
 */
class Seance
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $filmId;

    /**
     * @var int
     */
    private $hallId;

    /**
     * @var DateTime
     */
    private $seanceTime;

    /**
     * @var int
     */
    private $price;

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
     * SeanceGateway constructor.
     * @param Connect $connect
     */
    public function __construct(Connect $connect)
    {
        $this->pdo = $connect->getPdo();

        $this->insertStmt = $this->pdo->prepare(
            'INSERT INTO seance (film_id, hall_id, seance_time, price) VALUES (?, ?, ?, ?)'
        );

        $this->updateStmt = $this->pdo->prepare(
            'UPDATE seance SET film_id = ?, hall_id = ?, seance_time = ?, price = ? WHERE id = ?'
        );

        $this->deleteStmt = $this->pdo->prepare(
            'DELETE FROM seance WHERE id = ?'
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
     * @param int $id
     * @return Seance
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getFilmId(): int
    {
        return $this->filmId;
    }

    /**
     * @param int $filmId
     * @return Seance
     */
    public function setFilmId(int $filmId): self
    {
        $this->filmId = $filmId;

        return $this;
    }

    /**
     * @return int
     */
    public function getHallId(): int
    {
        return $this->hallId;
    }

    /**
     * @param int $hallId
     * @return Seance
     */
    public function setHallId(int $hallId): self
    {
        $this->hallId = $hallId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getSeanceTime(): DateTime
    {
        return $this->seanceTime;
    }

    /**
     * @param DateTime $seanceTime
     * @return Seance
     */
    public function setSeanceTime(DateTime $seanceTime): self
    {
        $this->seanceTime = $seanceTime;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Seance
     */
    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getId() . ', ' . $this->getFilmId() . ', ' . $this->getHallId() . ', ' .
            $this->getSeanceTime()->format('Y-m-d H:i:s') . ', ' .
            $this->getPrice();
    }

    /**
     * @return int
     */
    public function insert(): int
    {
        $this->insertStmt->execute([
            $this->getFilmId(),
            $this->getHallId(),
            $this->getSeanceTime()->format('Y-m-d H:i:s'),
            $this->getPrice(),
        ]);

        $this->setId($this->pdo->lastInsertId());

        return $this->getId();
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->getFilmId(),
            $this->getHallId(),
            $this->getSeanceTime()->format('Y-m-d H:i:s'),
            $this->getPrice(),
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
}