<?php

namespace App;

use App\Entity\EntityInterface;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;

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
        $this->manager = new Manager("mongodb://otus-mongo:27017");
        $this->collection = $collection;
    }

    /**
     * @param array $entity
     */
    public function insert(array $data): void
    {
        $bulk = new BulkWrite();
        $bulk->insert($data);
        $this->manager->executeBulkWrite('db.' . $this->collection, $bulk);
    }

    /**
     * @param array $filter
     * @param array $options
     * @return array
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public function find(array $filter, array $options = [])
    {
        $query = new Query($filter, $options);
        $cursor = $this->manager->executeQuery('db.' . $this->collection, $query);

        $result = [];
        foreach ($cursor as $document) {
            $result[] = $document;
        }

        return $result;
    }

    /**
     * @param string $id
     */
    public function delete(string $id): void
    {
        $bulk = new BulkWrite();
        $bulk->delete(['_id' => $id]);
        $this->manager->executeBulkWrite('db.' . $this->collection, $bulk);
    }
}