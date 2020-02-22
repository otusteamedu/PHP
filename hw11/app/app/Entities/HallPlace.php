<?php
namespace App\Entities;

use ActiveRecord\Employee;

class HallPlace{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var int
     */
    private $hall_place_id;

    /**
     * @var int
     */
    private $hall_id;

    /**
     * @var int
     */
    private $hall_place_num;


    /**
     * @var \PDOStatement
     */
    private static $selectQuery = "select hall_place_id, hall_id, hall_place_num from hall_places where hall_place_id = ?";

    /**
     * @var \PDOStatement
     */
    private $updateStmt;

    /**
     * @var \PDOStatement
     */
    private $insertStmt;

    /**
     * @var \PDOStatement
     */
    private $deleteStmt;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->insertStmt = $pdo->prepare(
            "insert into hall_places (hall_id, hall_place_num) values (?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update hall_places set hall_id = ?, hall_place_num = ? where hall_place_id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from hall_places where hall_place_id = ?");
    }

    /**
     * @return int
     */
    public function getHallPlaceId(): int
    {
        return $this->hall_place_id;
    }

    /**
     * @param int $id
     * @return HallPlace
     */
    public function setHallPlaceId(int $id): self
    {
        $this->hall_place_id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getHallId(): int
    {
        return $this->hall_id;
    }

    /**
     * @param int $id
     * @return HallPlace
     */
    public function setHallId(int $id): self
    {
        $this->hall_id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getHallPlaceNum(): string
    {
        return $this->hall_place_num;
    }

    /**
     * @param int $hall_place_num
     * @return HallPlace
     */
    public function setHallPlaceNum(string $hall_place_num): self
    {
        $this->hall_place_num = $hall_place_num;
        return $this;
    }

    /**
     * @param \PDO $pdo
     * @param int $id
     *
     * @return Employee
     */
    public static function getById(\PDO $pdo, int $id): self
    {
        $selectStmt = $pdo->prepare(self::$selectQuery);
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute([$id]);
        $result = $selectStmt->fetch();

        return (new self($pdo))
            ->setHallPlaceId($id)
            ->setHallId($result['hall_id'])
            ->setHallPlaceNum($result['hall_place_num']);
    }


    /**
     * @return bool
     */
    public function insert(): bool
    {
        $result = $this->insertStmt->execute([$this->hall_id, $this->hall_place_num]);
        $this->hall_place_id = $this->pdo->lastInsertId();
        return $result;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStmt->execute([$this->hall_id, $this->hall_place_num, $this->hall_place_id]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $hall_place_id = $this->hall_place_id;
        $this->hall_place_id = null;
        return $this->deleteStmt->execute([$hall_place_id]);
    }

}
