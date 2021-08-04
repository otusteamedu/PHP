<?php


namespace Services\Dao;


use app\Providers\AppServiceProvider;
use Services\Dao\DataMapper\Movie\Movie;
use Services\Dao\DataMapper\Movie\MovieMapper;
use Services\Dao\DataMapper\Room\Room;
use Services\Dao\DataMapper\Room\RoomMapper;
use Services\Dao\IdentityMap\ObjectsHolder;
use Services\Dao\TableGateway\MovieTG;
use Services\Dao\TableGateway\RoomTG;
use Services\Dto\MovieDto;
use PDO;
use Services\Dto\RoomDto;

/**
 * Class DaoService
 *
 * Сервис вызова методов из DataMapper для таблиц
 * 'movie',
 * 'room',
 *
 * @package Services\Dao
 */
class DaoService
{

    private PDO $connection;

    /**
     * DaoService constructor.
     */
    public function __construct()
    {
        $this->connection = (new AppServiceProvider())->getConnection();
    }

    /**
     * @param string $className
     * @param int $id
     * @return mixed
     */
    private function getFromIdentityMap(string $className, int $id): mixed
    {
        return ($record = ObjectsHolder::getRecord($className, $id)) != null // Есть ли  объект, если он уже был запрошен ранее
            ? $record
            : null;
    }

    /**
     * @return bool
     */
    private function isUseIdentityMap(): bool
    {
        return !isset($_ENV['USE_IDENTITY_MAP'])
            or mb_strtolower($_ENV['USE_IDENTITY_MAP']) == 'false'
            or $_ENV['USE_IDENTITY_MAP'] == false;
    }


    /*****************************************
     * Блок методов взаимодействия с фильмами.
     *****************************************/

    /**
     * Возвращает из DAO объект Movie (Фильм) по id
     *
     * @param int|null $id
     * @return Movie
     */
    public function getMovie(int $id = null): Movie
    {
        if ($this->isUseIdentityMap()) {
            echo "Без IdentityMap".PHP_EOL;
            return (new MovieMapper($this->connection))->findById($id);
        }
        echo "С IdentityMap".PHP_EOL;
        if (($record = $this->getFromIdentityMap(Movie::class, $id)) != null) {
            $movie = $record;
        } else {
            $movie = (new MovieMapper($this->connection))->findById($id);
            ObjectsHolder::addRecord($movie, $id);
        }
        return $movie;
    }

    /**
     * Возвращает из DAO массив объектов Movie (Фильмов)
     *
     * @return array
     */
    public function getMovies(): array
    {
        return (new MovieTG($this->connection))->getMovies();
    }

    /**
     * Добавляет в DAO объект Movie
     *
     * @param MovieDto $data
     * @return Movie
     */
    public function insertMovie(MovieDto $data): Movie
    {
        return (new MovieMapper($this->connection))->insert($data);
    }

    /**
     * Изменяет объет Movie в DAO
     *
     * @param Movie $movie
     * @return int
     */
    public function updateMovie(Movie $movie): int
    {
        return (new MovieMapper($this->connection))->update($movie);
    }

    /**
     * Удаляет из DAO объект Movie по id
     *
     * @param int|null $id
     * @return bool
     */
    public function deleteMovie(int $id = null): bool
    {
        return (new MovieMapper($this->connection))->delete($id);
    }


    /*******************************************
     * Блок методов взаимодействия с кинозалами.
     *******************************************/

    /**
     * Возвращает из DAO объект Room (Кинозал) по id
     *
     * @param int|null $id
     * @return Room
     */
    public function getRoom(int $id = null): Room
    {
        return (new RoomMapper($this->connection))->findById($id);
    }

    public function getRooms(): array
    {
        return (new RoomTG($this->connection))->getRooms();
    }

    /**
     * Добавляет в DAO объект Room
     *
     * @param RoomDto $data
     * @return Room
     */
    public function insertRoom(RoomDto $data): Room
    {
        return (new RoomMapper($this->connection))->insert($data);
    }

    /**
     * Изменяет объет Room в DAO
     *
     * @param Room $room
     * @return int
     */
    public function updateRoom(Room $room): int
    {
        return (new RoomMapper($this->connection))->update($room);
    }

    /**
     * Удаляет из DAO объект Room по id
     *
     * @param int|null $id
     * @return bool
     */
    public function deleteRoom(int $id = null): bool
    {
        return (new RoomMapper($this->connection))->delete($id);
    }

}
