<?php

namespace App\Repositories;

use App\Entities\Film;
use Otus\DBConnection;

class FilmsRepository extends BaseRepository
{

    public function __construct(DBConnection $db)
    {
        $this->selectStmt = $db->prepare(
            "select id, name, description, duration, age_limit from films where id = ?"
        );
        $this->insertStmt = $db->prepare(
            "insert into films (name, description, duration, age_limit) values (?,?,?,?)"
        );
        $this->updateStmt = $db->prepare(
            "update films set name = ?, description = ?, duration = ?, age_limit = ? where id = ?"
        );
        $this->deleteStmt = $db->prepare("delete from films where id = ?");

        $this->lastInsertIdStmt = $db->prepare('SELECT last_value FROM films_id_seq');
    }

    /**
     * @param int $id
     * @return Film|false
     */
    public function findById(int $id)
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return $result === false ?
            false :
            new Film(
                $id,
                $result['name'],
                $result['description'],
                $result['duration'],
                $result['age_limit']
            );
    }

    /**
     * @param array $raw
     * @return Film
     */
    public function insert(array $raw): Film
    {
        $this->insertStmt->execute([
            $raw['name'],
            $raw['description'],
            $raw['duration'],
            $raw['age_limit']
        ]);

        return new Film(
            $this->getLasInsertedId(),
            $raw['name'],
            $raw['description'],
            (int)$raw['duration'],
            (int)$raw['age_limit']
        );
    }

    /**
     * @param Film $film
     * @return bool
     */
    public function update(Film $film): bool
    {
        return $this->updateStmt->execute([
            $film->getName(),
            $film->getDescription(),
            $film->getDuration(),
            $film->getAgeLimit(),
            $film->getId(),
        ]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        return $this->deleteStmt->execute([$id]);
    }
}
