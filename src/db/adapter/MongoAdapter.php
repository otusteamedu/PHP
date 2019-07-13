<?php

namespace crazydope\youtube\db\adapter;


use MongoDB\DeleteResult;
use MongoDB\InsertManyResult;
use MongoDB\InsertOneResult;
use MongoDB\Client;
use MongoDB\Database;

class MongoAdapter implements MongoAdapterInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Database
     */
    protected $db;

    /**
     * AbstractMongoAdapter constructor.
     * @param string $connection
     * @param string $db
     */
    public function __construct(string $connection, string $db)
    {
        $this->client = new Client($connection);
        $this->db = $this->client->selectDatabase($db);
    }

    /**
     * @return Database
     */
    public function getDB(): Database
    {
        return $this->db;
    }

    /**
     * @param string $collection
     * @param array $document
     * @return InsertOneResult
     */
    public function insertOnce(string $collection, array $document): InsertOneResult
    {
        if (!is_array($document)) {
            throw new \InvalidArgumentException('$documents must be an array');
        }
        return $this->db->selectCollection($collection)->insertOne($document);
    }

    /**
     * @param string $collection
     * @param array $documents
     * @return InsertManyResult
     */
    public function insertMany(string $collection, array $documents): InsertManyResult
    {
        if (!is_array($documents)) {
            throw new \InvalidArgumentException('$documents must be an array');
        }
        return $this->db->selectCollection($collection)->insertMany($documents);
    }

    /**
     * @param string $collection
     * @param array $filter
     * @param array $options
     * @return array
     */
    public function find(string $collection, array $filter, array $options = []): array
    {
        return $this->db->selectCollection($collection)->find($filter, $options)->toArray();
    }

    /**
     * @param string $collection
     * @param string $id
     * @return DeleteResult
     */
    public function delete(string $collection,string $id): DeleteResult
    {
        return $this->db->selectCollection($collection)->deleteOne(['_id' => $id]);
    }

    /**
     * @param string $collection
     * @param array $pipeline
     * @param array $options
     * @return \Traversable
     */
    public function aggregate(string $collection, array $pipeline, array $options): \Traversable
    {
        return $this->db->selectCollection($collection)->aggregate($pipeline,$options);
    }
}