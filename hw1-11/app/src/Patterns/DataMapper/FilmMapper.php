<?php

namespace Src\Patterns\DataMapper;

use PDO;
use Src\Patterns\Collection;
use Src\Patterns\IdentityMap\ObjectWatcher;

/**
 * Class FilmMapper
 *
 * @package Src\Patterns\DataMapper
 */
class FilmMapper
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PDOStatement
     */
    private $selectStmt;

    /**
     * @var \PDOStatement
     */
    private $insertStmt;

    /**
     * @var \PDOStatement
     */
    private $updateStmt;

    /**
     * @var \PDOStatement
     */
    private $deleteStmt;

    /**
     * @var \PDOStatement
     */
    private \PDOStatement $getRecordsStmt;

    /**
     * @param $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "select id, name, year, country, description from film where id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into film (name, year, country, description) values (? ?, ?, ?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update film set name = ?, year = ?, country = ?, description = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from film where id = ?");

        $this->getRecordsStmt = $pdo->prepare('select id, name, year, country, description from film order by id limit :limit offset :offset');
    }

    /**
     * @param int $id
     *
     * @return Film
     */
    public function findById(int $id): Film
    {
        $identityMap = ObjectWatcher::getRecord(Film::class, $id);
        if (!is_null($identityMap)) {
            return $identityMap;
        }

        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new Film(
            $id,
            $result['name'],
            $result['year'],
            $result['country'],
            $result['description']
        );
    }

    /**
     * @param array $raw
     *
     * @return Film
     */
    public function insert(array $raw): Film
    {
        $this->insertStmt->execute([
            $raw['name'],
            $raw['year'],
            $raw['country'],
            $raw['description']
        ]);

        $film = new Film(
            (int)$this->pdo->lastInsertId(),
            $raw['name'],
            $raw['year'],
            $raw['country'],
            $raw['description']
        );

        ObjectWatcher::addRecord($film, $film->getId());

        return $film;
    }

    /**
     * @param Film $film
     *
     * @return bool
     */
    public function update(Film $film): bool
    {
        return $this->updateStmt->execute([
            $film->getName(),
            $film->getYear(),
            $film->getCountry(),
            $film->getDescription(),
            $film->getId(),
        ]);
    }

    /**
     * @param Film $film
     *
     * @return bool
     */
    public function delete(Film $film): bool
    {
        return $this->deleteStmt->execute([$film->getId()]);
    }

    public function getRecords(int $limit, int $offset): ?Collection
    {
        $this->getRecordsStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->getRecordsStmt->bindParam('limit', $limit, PDO::PARAM_INT);
        $this->getRecordsStmt->bindParam('offset', $offset, PDO::PARAM_INT);
        $this->getRecordsStmt->execute();

        $result = $this->getRecordsStmt->fetchAll();

        if (empty($result)) {
            return null;
        }

        return new Collection($result);
    }
}