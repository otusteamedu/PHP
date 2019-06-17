<?php

namespace App;

use App\Entity\EntityInterface;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Manager;

/**
 * Class MongoRepository
 * @package App
 */
class MongoRepository
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var string
     */
    private $collection;

    /**
     * Model constructor.
     */
    public function __construct(string $collection)
    {
        $this->manager = new Manager("mongodb://localhost:27017");
        $this->collection = $collection;
    }

    /**
     * @param EntityInterface $entity
     */
    public function insert(EntityInterface $entity): void
    {
        $bulk = new BulkWrite();
        $bulk->insert($entity->toArray());
        $this->manager->executeBulkWrite('db.' . $this->collection, $bulk);
    }
}