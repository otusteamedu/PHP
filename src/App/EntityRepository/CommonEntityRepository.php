<?php

namespace App\EntityRepository;

use App\EntityInterface\IEntity;
use App\EntityFilter\IEntityFilter;
use PDO;
use PDOStatement;

abstract class CommonEntityRepository implements IEntityRepository
{
    protected PDOStatement $selectSt;
    protected PDOStatement $createSt;
    protected PDOStatement $updateSt;
    protected PDOStatement $deleteSt;

    protected PDO $pdo;

    /**
     * CommonEntityRepository constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param IEntity $entity
     * @return array
     */
    abstract protected function fetchParams(IEntity $entity): array;

    /**
     * @param PDO $pdo
     * @return PDOStatement
     */
    abstract protected static function getSelectStatement(PDO $pdo
    ): PDOStatement;

    /**
     * @return PDOStatement
     */
    abstract protected function getCreateStatement(): PDOStatement;

    /**
     * @return PDOStatement
     */
    abstract protected function getUpdateStatement(): PDOStatement;

    /**
     * @return PDOStatement
     */
    abstract protected function getDeleteStatement(): PDOStatement;

    abstract protected static function buildEntityFromRow(
        PDO $pdo,
        array $row
    ): IEntity;

    /**
     * @param PDO           $pdo
     * @param IEntityFilter $filter
     * @return IEntity[]
     */
    public static function getEntitiesByFilter(
        PDO $pdo,
        IEntityFilter $filter
    ): array {
        $statement = static::getSelectStatement($pdo);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute($filter->fetchToAssoc());
        return array_map(
            fn(array $row): IEntity => static::buildEntityFromRow($pdo, $row),
            $statement->fetchAll()
        );
    }

    /**
     * @param IEntity $entity
     * @return bool
     */
    public function create(IEntity $entity): bool
    {
        $st = $this->getCreateStatement();
        if ($st->execute($this->fetchParams($entity))) {
            $entity->setId($this->pdo->lastInsertId());
            return true;
        }
        return false;
    }

    /**
     * @param IEntity $entity
     * @return bool
     */
    public function update(IEntity $entity): bool
    {
        return $this->getUpdateStatement()->execute(
            $this->fetchParams($entity)
        );
    }

    /**
     * @param IEntity $entity
     * @return bool
     */
    public function delete(IEntity $entity): bool
    {
        return $this->getDeleteStatement()->execute(
            $this->fetchParams($entity)
        );
    }
}