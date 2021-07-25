<?php


namespace Services\Dao\TableGateway;


use PDO;
use PDOStatement;
use Services\Dao\DataMapper\Room\Room;

/**
 * Class RoomTG
 *
 * TableGateway для таблицы 'room'
 *
 * @package Services\Dao\TableGateway
 */
class RoomTG
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
     * RoomTG constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStmt = $this->pdo->prepare(
            'select * from room'
        );
    }

    /**
     * Возвращает массив из всех кинозалов
     *
     * @return array
     */
    public function getRooms(): array
    {
        echo "Select *\n";
        $this->selectStmt->setFetchMode(PDO::FETCH_CLASS, Room::class);
        $this->selectStmt->execute();
        return $this->selectStmt->fetchAll();
    }

}
