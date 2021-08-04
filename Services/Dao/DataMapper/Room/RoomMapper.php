<?php


namespace Services\Dao\DataMapper\Room;


use Services\Dto\RoomDto;
use PDO;
use PDOStatement;

/**
 * Class RoomMapper
 *
 * Обеспечивает связь между таблицей 'room' и объектом Room
 *
 * @package Services\Dao\DataMapper\Room
 */
class RoomMapper
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
     * RoomMapper constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStmt = $pdo->prepare(
            "select id, name from room where id = :id"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into room (name) values (:name)"
        );
        $this->updateStmt = $pdo->prepare(
            "update room set name = :name where id = :id"
        );
        $this->deleteStmt = $pdo->prepare("delete from room where id = :id");
    }

    /**
     * Возвращает из таблицы 'room' Кинозал по id
     *
     * @param int $id
     * @return Room
     */
    public function findById(int $id): Room
    {
        echo "Finding\n";
        $this->selectStmt->setFetchMode(\PDO::FETCH_CLASS, RoomDto::class);
        $this->selectStmt->execute(['id' => $id]);
        $room = $this->selectStmt->fetch();
        return ($room == false) ? new Room() : new Room($room);
    }

    /**
     * Добавляет новый Кинозал в таблицу 'room'
     *
     * @param RoomDto $data
     * @return Room
     */
    public function insert(RoomDto $data): Room
    {
        echo "Inserting\n";
            $this->insertStmt->execute([
                $data->name,
            ]);
        $data->id = $this->pdo->lastInsertId();
        return new Room($data);
    }

    /**
     * Обновляет Кинозал в таблице 'room'
     *
     * @param Room $room
     * @return bool
     */
    public function update(Room $room): bool
    {
        echo "Updating\n";
        return $this->updateStmt->execute([
            'id'                => $room->getId(),
            'name'              => $room->getName(),
        ]);
    }

    /**
     * Удаляет Кинозал из таблицы 'room'
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        echo "Deleting\n";
        return $this->deleteStmt->execute(['id' => $id]);
    }

}
