<?php


namespace Services\Dao\DataMapper\Movie;


use PDO;
use PDOStatement;
use Services\Dto\MovieDto;

/**
 * Class MovieMapper
 * @package Services\Dao\DataMapper\Movie
 */
class MovieMapper
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
    private PDOStatement $selectGenreStmt;

    /**
     * @var PDOStatement
     */
    private PDOStatement $selectGenreIdStmtByName;

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
     * MovieMapper constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStmt = $pdo->prepare(
            "select id, name, age_limit, movie_genre_id from movie where id = :id"
        );
        $this->selectGenreStmt = $pdo->prepare(
            "select name from movie_genre where id = :id"
        );
        $this->selectGenreIdStmtByName = $pdo->prepare(
            "select id from movie_genre where name = :name"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into movie (name, age_limit, movie_genre_id) values (?, ?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update movie set name = :name, age_limit = :age_limit, movie_genre_id = :movie_genre_id where id = :id"
        );
        $this->deleteStmt = $pdo->prepare("delete from movie where id = :id");
    }

    /**
     * Возвращает из таблицы 'movie' фильм по id
     *
     * @param int $id
     * @return Movie
     */
    public function findById(int $id): Movie
    {
        echo "Finding\n";
        $this->selectStmt->setFetchMode(\PDO::FETCH_CLASS, MovieDto::class);
        $this->selectStmt->execute(['id' => $id]);
        $movie = $this->selectStmt->fetch();
        if ($movie == false) {
            return new Movie();
        }
        $this->selectGenreStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectGenreStmt->execute(['id' => $movie->movie_genre_id]);
        $movie->genre = $this->selectGenreStmt->fetch()['name'];
        return new Movie($movie);
    }

    /**
     * Добавляет новый фильм в таблицу 'movie'
     *
     * @param MovieDto $data
     * @return Movie
     */
    public function insert(MovieDto $data): Movie
    {
        echo "Inserting\n";
        $this->selectGenreIdStmtByName->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectGenreIdStmtByName->execute(['name' => $data->genre]);
        $data->movie_genre_id = $data->movie_genre_id ?? $this->selectGenreIdStmtByName->fetch()['id'];
        try {
            $this->insertStmt->execute([
                $data->name,
                $data->age_limit,
                $data->movie_genre_id,
            ]);
        } catch (\PDOException $pex) {
            print_r($pex);
        }
        $data->id = $this->pdo->lastInsertId();
        return new Movie($data);
    }

    /**
     * Обновляет фильм в таблице 'movie'
     *
     * @param Movie $movie
     * @return bool
     */
    public function update(Movie $movie): bool
    {
        echo "Updating\n";
        $this->updateStmt->execute([
            'id'                => $movie->getId(),
            'name'              => $movie->getName(),
            'age_limit'         => $movie->getAgeLimit(),
            'movie_genre_id'    => $movie->getMovieGenreId(),
        ]);
        return true;
    }

    /**
     * Удаляет фильм из таблицы 'movie'
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
