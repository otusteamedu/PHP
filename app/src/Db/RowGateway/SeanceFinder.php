<?php

namespace App\Db\RowGateway;

use App\Db\Connect;
use DateTime;
use Exception;
use PDO;
use PDOStatement;

/**
 * Class SeanceFinder
 * @package App\Db\RowGateway
 */
class SeanceFinder
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
     * @var bool|PDOStatement
     */
    private $selectStmt;

    /**
     * SeanceFinder constructor.
     * @param Connect $connect
     */
    public function __construct(Connect $connect)
    {
        $this->connect = $connect;
        $this->pdo = $connect->getPdo();

        $this->selectStmt = $this->pdo->prepare(
            'SELECT film_id, hall_id, seance_time, price FROM seance WHERE id = ?'
        );
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

        return (new Seance($this->connect))
            ->setId($id)
            ->setFilmId($result['film_id'])
            ->setHallId($result['hall_id'])
            ->setSeanceTime(new DateTime($result['seance_time']))
            ->setPrice($result['price']);
    }
}
