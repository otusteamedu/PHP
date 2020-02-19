<?php

namespace Tirei01\Hw12\Storage\Mapper;

use Tirei01\Hw12\Collection;
use Tirei01\Hw12\DomainObject;
use Tirei01\Hw12\Mapper;

class Element extends Mapper
{
    private $selectStmt;
    private $updateStmt;
    private $insertStmt;
    private $insertAllStmt;

    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = $this->pdo->prepare("SELECT * FROM element WHERE id=?");
        $this->updateStmt = $this->pdo->prepare("UPDATE element SET name=?, category_id=?, sort=?, code=? WHERE id=?");
        $this->insertStmt = $this->pdo->prepare(
            "INSERT INTO element (name, category_id, sort, code) VALUES ( ? , ? , ? , ? , ? )"
        );
        $this->insertAllStmt = $this->pdo->prepare("SELECT * FROM element");
    }
    public function update(DomainObject $object)
    {
        $value = array($object->getName(), $object->getType(), $object->getCategory()->getId(), $object->getSort(), $object->getCode(), $object->getId());
        $this->updateStmt->execute($value);
    }

    protected function doCreateObject(array $raw): DomainObject
    {
        $category = new Category();
        $element = new \Tirei01\Hw12\Storage\Element(
            $raw['id'],
            $raw['name'],
            $category->find($raw['category_id']),
            $raw['sort'],
            $raw['code']
        );
    }

    protected function doInsert(DomainObject $object)
    {
        $value = array($object->getName(), $object->getCategory()->getId(), $object->getSort(), $object->getCode());
        $this->insertStmt->execute($value);
        $id = $this->pdo->lastInsertId();
        $object->setId($id);
    }

    protected function selectStmt(): \PDOStatement
    {
        return $this->selectStmt;
    }

    protected function targetClass(): string
    {
        return static::class;
    }

    protected function selectAllStmt(): \PDOStatement
    {
        return $this->insertAllStmt;
    }

    protected function getCollection(array $raw): Collection
    {
       return new \Tirei01\Hw12\Storage\Collection\Element($raw);
    }
}