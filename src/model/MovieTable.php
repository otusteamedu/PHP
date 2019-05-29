<?php

namespace crazydope\theater\model;

use crazydope\theater\database\IdentityMapInterface;
use crazydope\theater\database\ResultSetInterface;
use crazydope\theater\database\TableGatewayInterface;

class MovieTable
{
    protected const MOVIE_SEQ = 'theater.movie_id_seq';

    /**
     * @var TableGatewayInterface
     */
    protected $tableGateway;

    /**
     * @var IdentityMapInterface
     */
    protected $identityMap;

    /**
     * MovieTable constructor.
     * @param TableGatewayInterface $table
     * @param IdentityMapInterface $identityMap
     */
    public function __construct(TableGatewayInterface $table, IdentityMapInterface $identityMap)
    {
        $this->tableGateway = $table;
        $this->identityMap = $identityMap;
    }

    /**
     * @return ResultSetInterface
     */
    public function getAll(): ResultSetInterface
    {
        return $this->tableGateway->select();
    }

    /**
     * @param int $id
     * @return Movie|null
     */
    public function getById(int $id): ?Movie
    {
        if ($this->identityMap->hasId($id)) {
            return $this->identityMap->getObject($id);
        }

        $rowSet = $this->tableGateway->select(['id' => $id]);

        if ($rowSet->count() > 0) {
            $movie = $rowSet->current();
            $this->identityMap->set($id, $movie);
            return $movie;
        }

        return null;
    }

    /**
     * @param Movie $movie
     * @return int
     */
    public function inset(Movie $movie): int
    {
        return $this->tableGateway->insert(['title' => $movie->getTitle(), 'description' => $movie->getDescription()]);
    }

    /**
     * @param Movie $movie
     * @return int
     */
    public function update(Movie $movie): int
    {
        $update = $this->tableGateway->update(
            ['title' => $movie->getTitle(), 'description' => $movie->getDescription()],
            ['id' => $movie->getId()]
        );

        if ($update && $this->identityMap->hasId($movie->getId())) {
            $this->identityMap->set($movie->getId(), $movie);
        }

        return $update;
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        $del = $this->tableGateway->delete(['id' => $id]);

        if ($del && $this->identityMap->hasId($id)) {
            $this->identityMap->deleteObject($id);
        }

        return $del;
    }

    /**
     * @return int
     */
    public function lastInsertId(): int
    {
        return $this->tableGateway->lastInsertId(self::MOVIE_SEQ);
    }
}