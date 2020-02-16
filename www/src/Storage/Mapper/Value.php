<?php

namespace Tirei01\Hw12\Storage\Mapper;

use Tirei01\Hw12\Collection;
use Tirei01\Hw12\DomainObject;
use Tirei01\Hw12\Mapper;

class Value extends Mapper
{

    private $selectStmt;
    private $updateStmt;
    private $insertStmt;
    private $insertAllStmt;
    private $findByCategory;
    private $findByCategoryProperty;
    private $findByProperty;
    public function __construct(\PDO $dbh)
    {
        parent::__construct($dbh);
        $this->selectStmt = $this->pdo->prepare("SELECT * FROM value WHERE id=?");
        $this->updateStmt = $this->pdo->prepare("UPDATE value SET property_id=?, category_id=?, s_value=?, i_value=? WHERE id=?");
        $this->insertStmt = $this->pdo->prepare("INSERT INTO value (property_id, category_id, s_value, i_value) VALUES ( ? , ? , ? , ?  )");
        $this->insertAllStmt = $this->pdo->prepare("SELECT * FROM value");
        $this->findByCategory = $this->pdo->prepare("SELECT * FROM value WHERE category_id=?");
        $this->findByCategoryProperty = $this->pdo->prepare("SELECT * FROM value WHERE category_id=? and property_id=?");
        $this->findByProperty = $this->pdo->prepare("SELECT * FROM value WHERE property_id=?");
    }

    public function update(DomainObject $object)
    {
        // TODO: Implement update() method.
    }

    protected function doCreateObject(array $raw): DomainObject
    {
        // TODO: Implement doCreateObject() method.
    }

    /**
     * @param \Tirei01\Hw12\Storage\Value $object
     */
    protected function doInsert(DomainObject $object)
    {
        $value = array($object->getProperty()->getId(), $object->getCategory()->getId(), $object->getStringValue(), $object->getNumericValue());
        $this->insertStmt->execute($value);
        $id = $this->pdo->lastInsertId();
        $object->setId($id);
    }

    protected function selectStmt(): \PDOStatement
    {
        // TODO: Implement selectStmt() method.
    }

    protected function targetClass(): string
    {
        // TODO: Implement targetClass() method.
    }

    protected function selectAllStmt(): \PDOStatement
    {
        // TODO: Implement selectAllStmt() method.
    }

    protected function getCollection(array $raw): Collection
    {
        // TODO: Implement getCollection() method.
    }
}