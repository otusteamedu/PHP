<?php


namespace Services\Dao;


use app\Providers\AppServiceProvider;
use Services\Dao\DataMapper\Movie\Movie;
use Services\Dao\DataMapper\Movie\MovieMapper;
use Services\Dto\MovieDto;

class DaoService
{

    private \PDO $connection;

    /**
     * DaoService constructor.
     */
    public function __construct()
    {
        $this->connection = (new AppServiceProvider())->getConnection();
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
        return (new MovieMapper($this->connection))->findById($id);
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

}
