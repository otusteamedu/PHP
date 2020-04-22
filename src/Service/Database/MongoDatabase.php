<?php


namespace Service\Database;

use MongoDB\Client;
use MongoDB\Collection;

class MongoDatabase implements DatabaseInterface
{
    private string $database;
    private string $collectionName;
    private Client $client;

    public function __construct()
    {
        $this->client = new Client('mongodb://youtube:password@127.0.0.1:27017/');
        $this->database = 'youtube';
    }

    public function setCollectionName(string $collectionName): void
    {
        $this->collectionName = $collectionName;
    }

    public function getCollection(): Collection
    {
        return $this->client->selectCollection($this->database, $this->collectionName);
    }
}