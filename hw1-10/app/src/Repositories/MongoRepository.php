<?php
namespace Src\Repositories;

use MongoDB\Client;
use MongoDB\Collection;
use Src\DTO\EventDto;
use Src\Models\Event;
use Src\StructureReaders\MongoStructureReader;

/**
 * Class MongoRepository
 *
 * @package Src\Repositories
 */
class MongoRepository
{
    public const  DB_NAME = 'mongo';
    private const EVENTS_INDEX_NAME = 'events';
    private const CONDITIONS_INDEX_NAME = 'events_conditions';
    private const INDEXES = [
        self::EVENTS_INDEX_NAME,
        self::CONDITIONS_INDEX_NAME,
    ];

    private Client $client;

    private $database;

    private Collection $collection;

    public function __construct()
    {
        $client = new Client($_ENV['DB_HOST']);
        $this->client = $client;
        $this->database = $client->{self::DB_NAME};
        $this->prepareIndexes();
    }

    private function prepareIndexes()
    {
        foreach (self::INDEXES as $indexName) {
            if ($this->isIndexCreated($indexName) === false) {
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

    /**
     * @param string $indexName
     *
     * @return bool
     * @throws \Exception
     */
    private function createIndex (string $indexName)
    {
        $structure = new MongoStructureReader($indexName);

        $this->database->createCollection(
            $indexName,
            ['validator' =>  $structure->getStructure()]
        );

        return true;
    }

    public function save (EventDto $eventDto): bool
    {

        $this->collection = $this->database->selectCollection(self::EVENTS_INDEX_NAME);

        $row = [
            '_id'        => $eventDto->getUid(),
            'id'         => $eventDto->getUid(),
            'priority'   => $eventDto->getPriority(),
            'conditions' => \GuzzleHttp\json_encode($eventDto->getConditions()),
            'event'      => $eventDto->event,
        ];

        try {
            $eventInsertResult = $this->collection->insertOne($row);
        } catch (\Exception $e) {
            return false;
        }

        $this->collection = $this->database->selectCollection(self::CONDITIONS_INDEX_NAME);

        $insertData = [];
        $event      = new Event($eventDto);
        $conditions = $event->getConditionsStrings();

        foreach ($conditions as $condition) {
            $insertData[] = [
                'event_id' => $eventDto->getUid(),
                'condition' => $condition,
            ];
        }
        try {
            $conditionsInsertResult = $this->collection->insertMany($insertData);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}