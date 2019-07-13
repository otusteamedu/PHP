<?php

namespace crazydope\youtube\db;

use crazydope\youtube\ArrayDocumentInterface;
use crazydope\youtube\db\adapter\MongoAdapterInterface;
use MongoDB\DeleteResult;
use MongoDB\InsertManyResult;
use MongoDB\InsertOneResult;

class AbstractStorage implements StorageInterface
{
    /**
     * @var MongoAdapterInterface
     */
    protected $adapter;

    /**
     * @var string
     */
    protected $collection;

    /**
     * @param ArrayDocumentInterface $data
     * @return InsertOneResult
     */
    public function insertOne(ArrayDocumentInterface $data): InsertOneResult
    {
        return $this->adapter->insertOnce($this->collection,$data->toArray());
    }

    /**
     * @param array $data
     * @return InsertManyResult
     */
    public function insertMany(array $data): InsertManyResult
    {
        return $this->adapter->insertMany($this->collection,$data);
    }

    /**
     * @param array $filter
     * @param array $options
     * @return array
     */
    public function find(array $filter, array $options = []): array
    {
        return $this->adapter->find($this->collection,$filter,$options);
    }

    /**
     * @param string $id
     * @return DeleteResult
     */
    public function delete(string $id): DeleteResult
    {
        return $this->adapter->delete($this->collection,$id);
    }

    /**
     * @param array $pipeline
     * @param array $options
     * @return \Traversable
     */
    public function aggregate(array $pipeline, array $options = []): \Traversable
    {
        return $this->adapter->aggregate($this->collection, $pipeline, $options);
    }
}