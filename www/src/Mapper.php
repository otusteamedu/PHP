<?php

namespace Tirei01\Hw12;

abstract class Mapper
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = \Tirei01\Hw12\Connector::getConnection();;
    }

    public function find($id)
    {
        $this->selectStmt()->execute([$id]);

        $row = $this->selectStmt()->fetch(\PDO::FETCH_ASSOC);
        $this->selectStmt()->closeCursor();
        if (!is_array($row)) {
            return null;
        }
        if (!isset($row['id'])) {
            return null;
        }
        $object = $this->doCreateObject($row);
        return $object;
    }

    public function createObject(array $raw): DomainObject
    {
        $obj = $this->doCreateObject($raw);
        return $obj;
    }

    public function insert(DomainObject $object){
        $this->doInsert($object);
    }

    public function findAll() : Collection {
        $this->selectAllStmt()->execute(array());
        return $this->getCollection($this->selectAllStmt()->fetchAll(\PDO::FETCH_ASSOC));
    }

    abstract public function update(DomainObject $object);

    abstract protected function doCreateObject(array $raw): DomainObject;

    abstract protected function doInsert(DomainObject $object);

    abstract protected function selectStmt(): \PDOStatement;

    abstract protected function targetClass(): string;

    abstract protected function selectAllStmt() : \PDOStatement;

    abstract protected function getCollection(array $raw): Collection;

    //abstract protected function getTable() : string;
}