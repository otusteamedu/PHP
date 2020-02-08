<?php declare(strict_types=1);

namespace Repository\Youtube;

use MongoDB\BSON\ObjectId;
use Service\Database\MongoDatabase;

class ChannelRepository
{
    private MongoDatabase $database;

    public function __construct()
    {
        $this->database = new MongoDatabase();
        $this->database->setCollectionName('youtube-channels');
    }

    public function saveOne(object $object): string
    {
        $collection = $this->database->getCollection();
        $result = $collection->insertOne($this->prepareDocument($object));

        return $result->getInsertedId()->__toString();
    }

    public function findOne(string $id): ?object
    {
        $collection = $this->database->getCollection();

        return $collection->findOne(['_id' => new ObjectId($id)]);
    }

    public function find(array $filter): array
    {
        $collection = $this->database->getCollection();
        $cursor = $collection->find($filter);

        return $cursor->toArray();
    }

    public function deleteOne(string $id): int
    {
        $collection = $this->database->getCollection();

        return $collection->deleteOne(['_id' => new ObjectId($id)])->getDeletedCount();
    }

    public function getSummaryStat(): array
    {
        $cursor = $this->database->getCollection()->aggregate([
            [
                '$unwind' => '$videos'
            ],
            [
                '$group' => [
                    '_id' => '$_id',
                    'title' => [
                        '$first' => '$title'
                    ],
                    'likes' => [
                        '$sum' => '$videos.likes'
                    ],
                    'dislikes' => [
                        '$sum' => '$videos.dislikes'
                    ],
                ]
            ]
        ]);

        return $cursor->toArray();
    }

    public function getTopChannels(int $limit = 3): array
    {
        $cursor = $this->database->getCollection()->aggregate([
            [
                '$unwind' => '$videos'
            ],
            [
                '$group' => [
                    '_id' => '$_id',
                    'title' => [
                        '$first' => '$title'
                    ],
                    'likes' => [
                        '$sum' => '$videos.likes'
                    ],
                    'dislikes' => [
                        '$sum' => '$videos.dislikes'
                    ]
                ]
            ],
            [
                '$project' => [
                    'title' => 1,
                    'weight' => [
                        '$round' => [
                            [
                                '$divide' => ['$likes', '$dislikes']
                            ],
                            4
                        ]
                    ]
                ]
            ],
            [
                '$sort' => [
                    'weight' => -1
                ]
            ],
            [
                '$limit' => $limit
            ]
        ]);

        return $cursor->toArray();
    }

    private function prepareDocument(object $object): array
    {
        return json_decode(json_encode($object), true);
    }
}
