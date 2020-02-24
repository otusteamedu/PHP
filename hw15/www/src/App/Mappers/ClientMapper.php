<?php

namespace App\Mappers;

use App\Entities\ClientEntity;
use App\Entities\UserEntity;
use Exception;

class ClientMapper extends AbstractMapper implements DataMapperInterface
{
    /**
     * @var \PDOStatement
     */
    protected $selectStmt;

    /**
     * @var \PDOStatement
     */
    protected $insertStmt;

    /**
     * @var \PDOStatement
     */
    protected $updateStmt;

    /**
     * @var \PDOStatement
     */
    protected $deleteStmt;

    /**
     * @var bool|\PDOStatement
     */
    protected $selectStmtByName;

    protected $tableName = 'client';
    protected $tableFields = ['name', 'address'];

    public function __construct()
    {
        parent::__construct();

        $this->selectStmt = $this->pdo->prepare($this->queries->findById($this->getTableName()));
        $this->insertStmt = $this->pdo->prepare($this->queries->insert($this->getTableName(), $this->getTableFields()));
        $this->updateStmt = $this->pdo->prepare($this->queries->update($this->getTableName(), $this->getTableFields()));
        $this->deleteStmt = $this->pdo->prepare($this->queries->delete($this->getTableName()));
    }

    public function findById($id): object
    {
        // TODO: Implement findById() method.
    }

    public function insert(object $entity): int
    {
        // TODO: Implement insert() method.
    }

    public function update(object $entity): bool
    {
        // TODO: Implement update() method.
    }

    public function delete(object $entity): bool
    {
        // TODO: Implement delete() method.
    }
}