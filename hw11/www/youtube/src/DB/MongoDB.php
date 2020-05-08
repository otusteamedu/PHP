<?php

namespace App\DB;

use MongoDB\Client;
use MongoDB\Collection;

class MongoDB
{

    /**
     * @var Client
     */
    private Client $client;
    /**
     * @var string
     */
    private string $database;

    /**
     * @var string
     */
    private string $collectionName;

    public function __construct()
    {
        $dsn = 'mongodb://'.getenv('MONGO_USERNAME').':'
            .getenv('MONGO_PASSWORD').'@'
            .getenv('MONGO_HOST').':'
            .getenv('MONGO_POST').'/';
        $this->client = new Client($dsn);
        $this->database = 'homework';
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