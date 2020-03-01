<?php

namespace Tirei01\Hw12\Storage\Mapper;

use Tirei01\Hw12\Collection;
use Tirei01\Hw12\DomainObject;
use Tirei01\Hw12\Mapper;
use Tirei01\Hw12\Storage\Category as CategoryStorage;
use Tirei01\Hw12\Storage\Collection\Property as PropertyCollection;
use Tirei01\Hw12\Storage\Property as PropertyStorage;

class Property extends Mapper
{
    private $selectStmt;
    private $updateStmt;
    private $insertStmt;
    private $insertAllStmt;
    private $findByCategory;
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = $this->pdo->prepare("SELECT * FROM property WHERE id=?");
        $this->updateStmt = $this->pdo->prepare("UPDATE property SET name=?, type=?, category_id=?, sort=?, code=? WHERE id=?");
        $this->insertStmt = $this->pdo->prepare("INSERT INTO property (name, type, category_id, sort, code) VALUES ( ? , ? , ? , ? , ? )");
        $this->insertAllStmt = $this->pdo->prepare("SELECT * FROM property order by sort asc");
        $this->findByCategory = $this->pdo->prepare("SELECT * FROM property WHERE category_id=? order by sort asc");
    }

    public function findByCategory(CategoryStorage $category): Collection {
        return new \Tirei01\Hw12\Storage\Collection\Prorogue\Property(
            $this,
            $this->findByCategory,
            array($category->getId())
        );
    }

    /**
     * @param PropertyStorage $object
     */
    public function update( DomainObject $object)
    {
        $value = array($object->getName(), $object->getType(), $object->getCategory()->getId(), $object->getSort(), $object->getCode(), $object->getId());
        $this->updateStmt->execute($value);
    }

    /**
     * @param array $raw
     *
     * @return PropertyStorage
     */
    protected function doCreateObject(array $raw): PropertyStorage
    {
        $category = new Category();

        return new PropertyStorage(
            $raw['id'],
            $raw['name'],
            $raw['type'],
            $category->find($raw['category_id']),
            $raw['sort'],
            $raw['code']
        );
    }

    /**
     * @return \PDOStatement
     */
    protected function selectStmt(): \PDOStatement
    {
        return $this->selectStmt;
    }

    protected function selectAllStmt(): \PDOStatement
    {
        return $this->insertAllStmt;
    }

    /**
     * @param PropertyStorage $object
     */
    protected function doInsert(DomainObject $object)
    {
        $value = array($object->getName(), $object->getType(), $object->getCategory()->getId(), $object->getSort(), $object->getCode());
        $this->insertStmt->execute($value);
        $id = $this->pdo->lastInsertId();
        $object->setId($id);
    }

    protected function getCollection(array $raw): Collection
    {
        return new PropertyCollection($raw, $this);
    }

    protected function targetClass(): string
    {
        return \Tirei01\Hw12\Storage\Property::class;
    }
}