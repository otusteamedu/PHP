<?php


namespace Services\Dao\TableGateway;


use PDO;
use PDOStatement;
use Services\Dao\DataMapper\Movie\Movie;
/**
 * Class MovieTG
 *
 * TableGateway для таблицы 'movie'
 *
 * @package Services\Dao\TableGateway
 */
class MovieTG
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
     * MovieTG constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStmt = $this->pdo->prepare(
            'select m.id, m.name, m.age_limit as "ageLimit", mg.id as "movieGenreId", mg.name as genre from movie m left join movie_genre mg on m.movie_genre_id = mg.id order by m.id'
        );
    }

    /**
     * Возвращает массив из всех фильмов
     *
     * @return array
     */
    public function getMovies(): array
    {
        echo "Select *\n";
        $this->selectStmt->setFetchMode(PDO::FETCH_CLASS, Movie::class);
        $this->selectStmt->execute();
        return $this->selectStmt->fetchAll();
    }

}
