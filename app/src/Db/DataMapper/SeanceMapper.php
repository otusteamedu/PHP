<?php

namespace App\Db\DataMapper;

use App\Db\Connect;
use DateTime;
use Exception;
use PDO;
use PDOStatement;

/**
 * Class SeanceMapper
 * @package App\Db\DataMapper
 */
class SeanceMapper
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
     * @return SeanceMapper
     * @throws Exception
     */
    public function findById(int $id): Seance
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        $seance = new Seance(
            $result['film_id'],
            $result['hall_id'],
            new DateTime($result['seance_time']),
            $result['price']
        );

        $seance->setId($id);

        return $seance;
    }

    /**
     * @param array $raw
     * @return Seance
     * @throws Exception
     */
    public function insert(array $raw)//: Seance
    {
        $this->insertStmt->execute([
            $raw['film_id'],
            $raw['hall_id'],
            $raw['seance_time'],
            $raw['price']
        ]);

        $seance = new Seance(
            $raw['film_id'],
            $raw['hall_id'],
            new DateTime($raw['seance_time']),
            $raw['price']
        );

        $seance->setId((int)$this->pdo->lastInsertId());

        return $seance;
    }

    /**
     * @return bool
     */
    public function update(Seance $seance): bool
    {
        return $this->updateStmt->execute([
            $seance->getFilmId(),
            $seance->getHallId(),
            $seance->getSeanceTime()->format('Y-m-d H:i:s'),
            $seance->getPrice(),
            $seance->getId()
        ]);
    }

    /**
     * @return bool
     */
    public function delete(Seance $seance): bool
    {
        return $this->deleteStmt->execute([$seance->getId()]);
    }
}