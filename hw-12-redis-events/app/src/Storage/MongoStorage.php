<?php

namespace App\Storage;

use App\Config\Config;
use App\Log\Log;
use App\Models\DTO\EventDTO;
use App\Models\Event;
use App\Structures\MongoStructureReader;
use Exception;
use MongoDB\Client;
use Symfony\Component\Yaml\Exception\ParseException;

class MongoStorage extends NoSQLStorage
{
    public const  STORAGE_NAME          = 'mongo';
    private const EVENTS_INDEX_NAME     = 'events';
    private const CONDITIONS_INDEX_NAME = 'events_conditions';

    private const INDEXES = [
        self::EVENTS_INDEX_NAME,
        self::CONDITIONS_INDEX_NAME,
    ];

    private Client              $client;
    private                     $database;
    private \MongoDB\Collection $collection;

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
        foreach (self::INDEXES as $indexName) {
            if ($this->isIndexCreated($indexName) === false) {
                Log::getInstance()->addRecord('creating index ' . $indexName);
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

    public function search (array $params): ?string
    {
        return '';
        // TODO: Implement search() method.
    }

    public function store (EventDTO $eventDTO): bool
    {
        $this->collection = $this->database->selectCollection(self::EVENTS_INDEX_NAME);

        $row = [
            '_id'        => $eventDTO->getId(),
            'id'         => $eventDTO->getId(),
            'priority'   => $eventDTO->getPriority(),
            'conditions' => json_encode($eventDTO->getConditions()),
            'event'      => $eventDTO->event,
        ];

        try {
            $eventInsertResult = $this->collection->insertOne($row);
        } catch (Exception $e) {
            return false;
        }

        $this->collection = $this->database->selectCollection(self::CONDITIONS_INDEX_NAME);

        $insertData = [];
        $event      = new Event($eventDTO);
        $conditions = $event->getConditionsStrings();

        foreach ($conditions as $condition) {
            $insertData[] = [
                'event_id' => $eventDTO->getId(),
                'condition' => $condition,
            ];
        }

        try {
            $conditionsInsertResult = $this->collection->insertMany($insertData);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function deleteAll (): int
    {
        $affected = 0;

        foreach (self::INDEXES as $collectionName) {
            $affected += $this->deleteCollection($collectionName);
        }

        return $affected;
    }

    private function deleteCollection(string $collectionName): int
    {
        $this->collection = $this->database->selectCollection($collectionName);

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
        $this->collection = $this->database->selectCollection(self::EVENTS_INDEX_NAME);

        $cursor = $this->collection->find();

        $result = [];

        foreach($cursor as $document) {
            $document['conditions'] = json_decode($document->conditions ?? '', true);

            $result[] = $document;
        }

        return $result;
    }
}