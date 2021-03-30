<?php


namespace App\Services\Orm\Mapping;

use App\Services\Orm\Interfaces\ModelBuilderInterface;
use App\Services\Orm\Interfaces\OrmModelInterface;
use App\Services\Orm\Interfaces\MapperInterface;
use PDO;
use PDOStatement;


abstract class AbstractMapper implements MapperInterface
{
    protected ModelBuilderInterface $builder;

    protected PDOStatement $selectStmt;
    protected PDOStatement $insertStmt;
    protected PDOStatement $updateStmt;
    protected PDOStatement $deleteStmt;

    /**
     * AbstractMapper constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->selectStmt = $pdo->prepare($this->getSelectQuery());
        $this->insertStmt = $pdo->prepare($this->getInsertQuery());
        $this->updateStmt = $pdo->prepare($this->getUpdateQuery());
        $this->deleteStmt = $pdo->prepare($this->getDeleteQuery());
    }


    public function insert(array $raw): OrmModelInterface
    {
        // TODO: Implement insert() method.
    }

    public function update(OrmModelInterface $model): bool
    {
        // TODO: Implement update() method.
    }

    public function delete(OrmModelInterface $model): bool
    {
        // TODO: Implement delete() method.
    }

    public function findById(int $id): ?OrmModelInterface
    {
        // TODO: Implement findById() method.
    }

    public function getBuilder(): ModelBuilderInterface
    {
        return $this->builder;
    }

    abstract protected function getSelectQuery(): string;

    abstract protected function getInsertQuery(): string;

    abstract protected function getUpdateQuery(): string;

    abstract protected function getDeleteQuery(): string;
}
