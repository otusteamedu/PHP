<?php

namespace Tirei01\Hw12\Property\Mapper;

use Tirei01\Hw12\DomainObject;
use Tirei01\Hw12\Mapper;
use Tirei01\Hw12\Property\Category as PropertyCategoryDomain;

class Category extends Mapper
{
    private $selectStmt;
    private $updateStmt;
    private $insertStmt;

    public function __construct(\PDO $dbh)
    {
        parent::__construct($dbh);
        $this->selectStmt = $this->pdo->prepare("SELECT * FROM property_category WHERE id=?");
        $this->updateStmt = $this->pdo->prepare("UPDATE property_category SET name=?, code=?, sort=? WHERE id=?");
        $this->insertStmt = $this->pdo->prepare("INSERT INTO property_category (name) VALUES ( ? )");
    }

    /**
     * @param PropertyCategoryDomain $object
     */
    public function update( DomainObject $object)
    {
        $values = array($object->getName(), $object->getCode(), $object->getSort(), $object->getId());
        $this->updateStmt->execute($values);
    }

    protected function doCreateObject(array $raw): PropertyCategoryDomain
    {
        return new PropertyCategoryDomain($raw['id'], $raw['name'], $raw['sort'], $raw['code']);
    }

    /**
     * @param PropertyCategoryDomain $object
     */
    protected function doInsert(DomainObject $object)
    {
        $value = array($object->getName());
        $resss = $this->insertStmt->execute($value);
        // TODO DEL THIS
        echo "<pre style='color:red; clear: both;'>";
        var_dump($resss);
        echo "</pre>";
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
}