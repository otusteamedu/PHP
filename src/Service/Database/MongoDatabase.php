<?php declare(strict_types=1);

namespace Service\Database;

use MongoDB\Client;
use MongoDB\Collection;

class MongoDatabase
{
    private string $database;
    private string $collectionName;
    private Client $client;

    public function __construct()
    {
        $this->client = new Client('mongodb://root:password@mongo:27017/');
        $this->database = 'admin';
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
