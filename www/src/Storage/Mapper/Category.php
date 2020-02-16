<?php

namespace Tirei01\Hw12\Storage\Mapper;

use Tirei01\Hw12\Collection;
use Tirei01\Hw12\DomainObject;
use Tirei01\Hw12\Mapper;
use Tirei01\Hw12\Storage\Category as StorageCategoryDomain;

class Category extends Mapper
{
    private $selectStmt;
    private $updateStmt;
    private $insertStmt;
    private $insertAllStmt;

    public function __construct(\PDO $dbh)
    {
        parent::__construct($dbh);
        $this->selectStmt = $this->pdo->prepare("SELECT * FROM category WHERE id=?");
        $this->updateStmt = $this->pdo->prepare("UPDATE category SET name=?, code=?, sort=? WHERE id=?");
        $this->insertStmt = $this->pdo->prepare("INSERT INTO category (name, code, sort) VALUES ( ? , ? , ? )");
        $this->insertAllStmt = $this->pdo->prepare("SELECT * FROM category");
    }


    /**
     * @param StorageCategoryDomain $object
     */
    public function update( DomainObject $object)
    {
        $values = array($object->getName(), $object->getCode(), $object->getSort(), $object->getId());
        $this->updateStmt->execute($values);
    }

    /**
     * @param array $raw
     *
     * @return StorageCategoryDomain
     */
    protected function doCreateObject(array $raw): StorageCategoryDomain
    {
        return new StorageCategoryDomain($raw['id'], $raw['name'], $raw['sort'], strval($raw['code']));
    }

    /**
     * @param StorageCategoryDomain $object
     */
    protected function doInsert(DomainObject $object)
    {
        $value = array($object->getName(), $object->getCode(), $object->getSort());
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
        return new \Tirei01\Hw12\Storage\Collection\Category($raw, $this);
    }

    protected function getTable(): string
    {
        return 'category';
    }
}