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
    private $findByElementCategoryProperty;

    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = $this->pdo->prepare("SELECT * FROM value WHERE id=?");
        $this->insertAllStmt = $this->pdo->prepare("SELECT * FROM value");
        $this->findByElementCategoryProperty =
            $this->pdo->prepare("SELECT * FROM value WHERE element_id=? and category_id=? and property_id=?");
    }

    /**
     * @param \Tirei01\Hw12\Storage\Element  $element
     * @param \Tirei01\Hw12\Storage\Property $property
     *
     * @return \Tirei01\Hw12\Storage\Element
     */
    public function findByElem(\Tirei01\Hw12\Storage\Element $element, \Tirei01\Hw12\Storage\Property $property)
    {
        $element_id = $element->getId();
        $category_id = $element->getCategory()->getId();
        $property_id = $property->getId();
        $this->findByElementCategoryProperty->execute([$element_id, $category_id, $property_id]);
        $row = $this->findByElementCategoryProperty->fetch(\PDO::FETCH_ASSOC);
        $this->findByElementCategoryProperty->closeCursor();
        if (!is_array($row)) {
            return null;
        }
        if (!isset($row['id'])) {
            return null;
        }
        return $this->doCreateObject($row);
    }

    /**
     * @param \Tirei01\Hw12\Storage\Value $object
     */
    public function update(DomainObject $object)
    {
        $value = array($object->getValue(), $object->getId());
        $value_code = 'value_' . $object->getProperty()->getType();
        $this->updateStmt = $this->pdo->prepare("UPDATE value SET " . $value_code . "=? WHERE id=?");
        $this->updateStmt->execute($value);
    }

    protected function doCreateObject(array $raw): DomainObject
    {
        $obProp = new Property();
        $prop = $obProp->find($raw['property_id']);
        $obElem = new Element();
        $elem = $obElem->find($raw['element_id']);
        $type = $prop->getType();
        return new \Tirei01\Hw12\Storage\Value(
            $raw['id'], $prop, $elem, $raw['value_' . $type]
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
            $object->getValue(),
            $object->getElement()->getId(),
        );
        $value_code = 'value_' . $object->getProperty()->getType();
        $this->insertStmt = $this->pdo->prepare(
            "INSERT INTO value (property_id, category_id, " . $value_code . ", element_id) VALUES ( ? , ? , ? , ? )"
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
        return \Tirei01\Hw12\Storage\Value::class;
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