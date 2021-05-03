<?php

declare(strict_types=1);

namespace App\Model\Film\DataMapper;

use App\Database\QueryBuilder;
use App\Model\Film\Entity\Film;
use App\Model\Film\Entity\FilmCollection;
use App\Model\Film\Entity\FilmId;
use App\Model\Film\Exception\FilmNotFoundException;
use App\Service\IdentityMap;
use Exception;

class FilmMapper implements FilmMapperInterface
{
    private const TABLE_NAME = 'films';

    private QueryBuilder $queryBuilder;
    private IdentityMap  $identityMap;

    public function __construct(QueryBuilder $queryBuilder, IdentityMap $identityMap)
    {
        $this->queryBuilder = $queryBuilder;
        $this->identityMap = $identityMap;
    }

    /**
     * @throws Exception
     */
    public function getAll(): FilmCollection
    {
        $data = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->select(['*'])
            ->orderBy(['name'])
            ->fetchAll();

        return $this->buildFilmCollection($data);
    }

    private function buildFilmCollection(array $data): FilmCollection
    {
        $collection = new FilmCollection();

        array_walk($data, fn($value) => $collection->append($this->buildFilm($value)));

        return $collection;
    }

    /**
     * @throws Exception
     */
    public function getOne(FilmId $id): Film
    {
        if (!empty($film = $this->identityMap->get(Film::class, $id->getValue()))) {
            /* @var Film $film */
            return $film;
        }

        $data = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->select(['*'])
            ->andWhere(['id' => $id->getValue()])
            ->fetch();

        if (!$data) {
            throw new FilmNotFoundException('Фильм не найден');
        }

        $film = $this->buildFilm($data);

        $this->identityMap->set($film, $id->getValue());

        return $film;
    }

    private function buildFilm(array $data): Film
    {
        $film = new Film(new FilmId($data['id']), $data['name']);

        $film->changeProductionYear($data['production_year']);

        return $film;
    }

    /**
     * @throws Exception
     */
    public function add(Film $film): void
    {
        $data = $film->toArray();

        $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->insert($data)
            ->execute();

        $this->identityMap->set($film, $film->getId()->getValue());
    }

    /**
     * @throws Exception
     */
    public function update(Film $film): void
    {
        $data = $film->toArray();

        $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->update($data)
            ->andWhere(['id' => $film->getId()->getValue()])
            ->execute();

        $this->identityMap->set($film, $film->getId()->getValue());
    }

    /**
     * @throws Exception
     */
    public function delete(Film $film): void
    {
        $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->delete()
            ->andWhere(['id' => $film->getId()->getValue()])
            ->execute();

        $this->identityMap->delete($film, $film->getId()->getValue());
    }
}