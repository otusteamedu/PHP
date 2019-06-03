<?php

namespace App\Db\TableGateway;

use App\Db\Connect;
use DateTime;
use PDO;
use PDOStatement;

/**
 * Class TableGateway
 * @package App\Db
 */
class TableGateway
{
    /**
     * @var PDO
     */
    private $pdo;

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
     * TableGateway constructor.
     * @param Connect $connect
     */
    public function __construct(Connect $connect)
    {
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
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);

        return $this->selectStmt->fetch();
    }

    /**
     * @param int $filmId
     * @param int $hallId
     * @param DateTime $seanceTime
     * @param int $price
     * @return int
     */
    public function insert(int $filmId, int $hallId, DateTime $seanceTime, int $price): int
    {
        $this->insertStmt->execute([
            $filmId,
            $hallId,
            $seanceTime->format('Y-m-d H:i:s'),
            $price,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @param int $id
     * @param int $filmId
     * @param int $hallId
     * @param DateTime $seanceTime
     * @param int $price
     * @return bool
     */
    public function update(int $id, int $filmId, int $hallId, DateTime $seanceTime, int $price): bool
    {
        $this->updateStmt->setFetchMode(PDO::FETCH_ASSOC);

        return $this->updateStmt->execute([
            $filmId,
            $hallId,
            $seanceTime->format('Y-m-d H:i:s'),
            $price,
            $id
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
}