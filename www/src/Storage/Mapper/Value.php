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

    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = $this->pdo->prepare("SELECT * FROM value WHERE id=?");
        $this->updateStmt = $this->pdo->prepare("UPDATE value SET s_value=?, i_value=? WHERE id=?");
        $this->insertStmt = $this->pdo->prepare(
            "INSERT INTO value (property_id, category_id, s_value, i_value) VALUES ( ? , ? , ? , ?  )"
        );
        $this->insertAllStmt = $this->pdo->prepare("SELECT * FROM value");

        $this->findByProperty = $this->pdo->prepare("SELECT * FROM value WHERE property_id=?");
        $this->findByCategory = $this->pdo->prepare("SELECT * FROM value WHERE category_id=?");
        $this->findByCategoryProperty =
            $this->pdo->prepare("SELECT * FROM value WHERE category_id=? and property_id=?");
    }

    public function findByProperty(\Tirei01\Hw12\Storage\Property $property): Collection
    {
        $this->findByProperty->execute(array($property->getId()));
        return $this->getCollection($this->findByProperty->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * @param \Tirei01\Hw12\Storage\Value $object
     */
    public function update(DomainObject $object)
    {
        $value = array($object->getStringValue(), $object->getNumericValue(), $object->getId());
        $this->updateStmt->execute($value);
    }

    protected function doCreateObject(array $raw): DomainObject
    {
        $obProp = new Property();
        $prop = $obProp->find($raw['property_id']);
        return new \Tirei01\Hw12\Storage\Value(
            $raw['id'], $obProp->find($raw['property_id']), $raw['i_value'], $raw['s_value']
        );
    }

    /**
     * @param \Tirei01\Hw12\Storage\Value $object
     */
    protected function doInsert(DomainObject $object)
    {
        $value = array(
            $object->getProperty()->getId(),
            $object->getCategory()->getId(),
            $object->getStringValue(),
            $object->getNumericValue(),
        );
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
        return new \Tirei01\Hw12\Storage\Collection\Value($raw, $this);
    }
}