<?php

namespace App\Entities;


class Hall
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var int
     */
    private $hall_id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var HallPlace[]
     */
    private $places;

    /**
     * @var \PDOStatement
     */
    private static $selectQuery = "SELECT hall_id, name FROM halls WHERE hall_id = ?";

    /**
     * @var \PDOStatement
     */
    private static $selectPlacesQuery = "SELECT hall_place_id, hall_place_num FROM hall_places WHERE hall_id = ? ORDER BY hall_place_num ASC";

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
            "INSERT INTO halls (name) VALUES (?)"
        );
        $this->updateStmt = $pdo->prepare(
            "UPDATE halls SET name = ? WHERE hall_id = ?"
        );
        $this->deleteStmt = $pdo->prepare("DELETE FROM halls WHERE hall_id = ?");
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
     * @return Hall
     */
    public function setHallId(int $id): self
    {
        $this->hall_id = $id;
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
     * @return Hall
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param \PDO $pdo
     * @param int $id
     *
     * @return Hall
     */
    public static function getById(\PDO $pdo, int $id): self
    {
        $selectStmt = $pdo->prepare(self::$selectQuery);
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute([$id]);
        $result = $selectStmt->fetch();

        return (new self($pdo))
            ->setHallId($id)
            ->setName($result['name']);
    }


    /**
     * @return bool
     */
    public function insert(): bool
    {
        $result = $this->insertStmt->execute([$this->name]);
        $this->hall_id = $this->pdo->lastInsertId();
        return $result;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStmt->execute([$this->name, $this->hall_id]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $hall_id = $this->hall_id;

        $places = $this->getPlaces();

        foreach ($places as $place) {
            $place->delete();
        }

        $this->hall_id = null;
        $this->places = null;

        return $this->deleteStmt->execute([$hall_id]);
    }


    /**
     * @param bool $force - форсированный запрос "свежих" данных
     * @return HallPlace[]|array
     */
    public function getPlaces(bool $force = false)
    {

        if ($force || null === $this->places) {

            $selectStmt = $this->pdo->prepare(self::$selectPlacesQuery);
            $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
            $selectStmt->execute([$this->hall_id]);
            $places = [];

            while ($item = $selectStmt->fetch()) {

                $places[] = (new HallPlace($this->pdo))
                    ->setHallPlaceId($item['hall_place_id'])
                    ->setHallId($this->hall_id)
                    ->setHallPlaceNum($item['hall_place_num']);
            }

            $this->places = $places;
        }

        return $this->places;
    }

}
