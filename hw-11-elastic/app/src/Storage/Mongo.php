<?php

namespace Storage;

use Config\Config;
use Exception;
use Models\ChannelDTO;
use Models\DTO;
use MongoDB\Client;
use Models\Channel;
use Models\Video;
use MongoDB\Collection;
use Structures\MongoStructureReader;

class Mongo extends NoSQLStorage
{
    public const STORAGE_NAME = 'mongo';

    protected $client;
    private   $database;

    private Collection $collection;

    public function __construct()
    {
        $dbHost = Config::getInstance()->getItem(Storage::DB_HOST_CONFIG_KEY);
        $client = new Client($dbHost);

        $this->client = $client;

        $this->database = $client->{self::STORAGE_NAME};

        $this->prepareIndexes();
    }

    private function prepareIndexes()
    {
        foreach (self::INDEXES as $indexName) {
            if ($this->isIndexCreated($indexName) === false) {
                echo 'creating index ' . $indexName . PHP_EOL;
                $this->createIndex($indexName);
            }
        }
    }

    private function isIndexCreated (string $indexName): bool
    {
        foreach ($this->database->listCollections() as $collection) {
            if ($collection->getName() == $indexName) {
                return true;
            }
        }
        return false;
    }

    private function createIndex (string $indexName)
    {
        $structure = new MongoStructureReader($indexName);

        $this->database->createCollection(
            $indexName,
            ['validator' =>  $structure->getStructure()]
        );

        return true;
    }

    public function getAll(string $indexName): array
    {
        return [];
    }

    public function store (DTO $dto, string $indexName): bool
    {
        $this->collection = $this->database->selectCollection($indexName);

        $row = $dto->asArray();

        $row['_id'] = $row['id'];

        try {
            $insertResult = $this->collection->insertOne($row);

            if ($insertResult->getInsertedCount() === 1) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }

        return false;
    }
}