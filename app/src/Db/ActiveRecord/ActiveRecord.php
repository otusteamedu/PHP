<?php

namespace App\Db\ActiveRecord;

use App\Db\Connect;
use App\Db\RowGateway\Seance;
use DateTime;
use Exception;
use PDO;
use PDOStatement;

/**
 * Class ActiveRecord
 * @package App\Db\ActiveRecord
 */
class ActiveRecord
{
    private const DOLLAR_K = 65.43;
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
     * SeanceGateway constructor.
     * @param Connect $connect
     */
    public function __construct(Connect $connect)
    {
        $this->connect = $connect;
        $this->pdo = $connect->getPdo();

        $this->selectStmt = $this->pdo->prepare(
            'SELECT film_id, hall_id, seance_time, price FROM seance WHERE id = ?'
        );

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
     * @param int $id
     * @return Seance
     * @throws Exception
     */
    public function findById(int $id): Seance
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return (new self($this->connect))
            ->setId($id)
            ->setFilmId($result['film_id'])
            ->setHallId($result['hall_id'])
            ->setSeanceTime(new DateTime($result['seance_time']))
            ->setPrice($result['price']);
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
     * @return float
     */
    public function getDollarPrice(): float
    {
        return $this->getPrice() * self::DOLLAR_K;
    }
}