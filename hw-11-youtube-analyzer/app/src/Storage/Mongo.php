<?php

namespace App\Storage;

use App\Config\Config;
use App\Models\DTO\DTO;
use App\Structures\MongoStructureReader;
use Exception;
use MongoDB\Client;
use App\Models\Video;
use MongoDB\Collection;

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

    public function getAll (string $indexName): array
    {
        $this->collection = $this->database->selectCollection($indexName);

        $structureReader = new MongoStructureReader($indexName);
        $properties      = $structureReader->getPropertiesList();

        $response = $this->collection->find([], []);

        $result = [];

        foreach ($response as $row) {
            $item = [];

            $row = (array) $row->jsonSerialize();

            foreach ($row as $field => $value) {
                if (in_array($field, $properties)) {
                    $item[$field] = $value;
                }
            }

            $result[] = $item;
        }

        return $result;
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

    public function delete (string $id, string $indexName): bool
    {
        $this->collection = $this->database->selectCollection($indexName);

        $result = $this->collection->deleteOne(
            [
                '_id' => $id
            ],
        );

        if ($result->getDeletedCount() === 1) {
            return true;
        }

        return false;
    }

    public function calculateStats (string $channelId): array
    {
        $this->collection = $this->database->selectCollection(Video::TABLE_NAME);

        $cursor = $this->collection->aggregate(
            [
                [
                    '$group' => [
                        '_id'          => '$channelId',
                        'likeSum'    => ['$sum' => '$likeCount'],
                        'dislikeSum' => ['$sum' => '$dislikeCount'],
                        'viewSum'    => ['$sum' => '$viewCount'],
                        'commentSum' => ['$sum' => '$commentCount'],
                    ],
                ],
                [
                    '$match' => [
                        '_id' => [
                            '$eq' => $channelId,
                        ],
                    ],
                ],
            ]
        );

        $rawStats = [];

        foreach ($cursor as $item) {
            $rawStats = (array)$item->jsonSerialize();
        }

        return [
            'channelId'  => $channelId ?? '',
            'likeSum'    => $rawStats['likeSum'] ?? 0,
            'dislikeSum' => $rawStats['dislikeSum'] ?? 0,
            'viewSum'    => $rawStats['viewSum'] ?? 0,
            'commentSum' => $rawStats['commentSum'] ?? 0,
        ];
    }
}