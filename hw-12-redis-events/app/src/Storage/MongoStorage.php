<?php

namespace App\Storage;

use App\Config\Config;
use App\Log\Log;
use App\Models\DTO\EventDTO;
use App\Structures\MongoStructureReader;
use Exception;
use MongoDB\Client;

class MongoStorage extends NoSQLStorage
{
    public const  STORAGE_NAME = 'mongo';
    private const INDEX_NAME   = 'events';

    private Client $client;
    private $database;

    public function __construct()
    {
        $dbHost = Config::getInstance()->getItem(Storage::STORAGE_CONFIG_KEY)[Storage::DB_HOST_CONFIG_KEY];
        $client = new Client($dbHost);

        $this->client = $client;

        $this->database = $client->{self::STORAGE_NAME};

        $this->prepareIndexes();
    }

    private function prepareIndexes()
    {
        if ($this->isIndexCreated(self::INDEX_NAME) === false) {
            Log::getInstance()->addRecord('creating index ' . self::INDEX_NAME);
            $this->createIndex(self::INDEX_NAME);
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

    public function search (array $params): ?string
    {
        // TODO: Implement search() method.
    }

    public function store (EventDTO $eventDTO): bool
    {
        $this->collection = $this->database->selectCollection(self::INDEX_NAME);

        $row = [
            '_id'        => $eventDTO->getId(),
            'id'         => $eventDTO->getId(),
            'priority'   => $eventDTO->getPriority(),
            'conditions' => json_encode($eventDTO->getConditions()),
            'event'      => $eventDTO->event,
        ];

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

    public function deleteAll (): int
    {
        $this->collection = $this->database->selectCollection(self::INDEX_NAME);

        $was = $this->collection->countDocuments();

        $this->collection->drop();

        $now = $this->collection->countDocuments();

        if ($now === 0) {
            return $was;
        }

        return 0;
    }

    public function getList (): array
    {
        $this->collection = $this->database->selectCollection(self::INDEX_NAME);

        $cursor = $this->collection->find();

        $result = [];

        foreach($cursor as $document) {
            $document['conditions'] = json_decode($document->conditions ?? '', true);

            $result[] = $document;
        }

        return $result;
    }
}