<?php


namespace Service;


use MongoDB\BSON\ObjectId;
use Service\Database\DatabaseInterface;
use Service\Database\MongoDatabase;

class ChannelStorage implements StorageInterface
{
    private DatabaseInterface $database;

    public function __construct()
    {
        $this->database = new MongoDatabase();
        $this->database->setCollectionName('youtube-channels');
    }

    public function insertOne(object $object): string
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

    public function getSummary(string $channelId): array
    {
        $cursor = $this->database->getCollection()->aggregate([
            [
                '$unwind' => '$videos'
            ],
            [
                '$match' => [
                    'channelId' => $channelId
                ]
            ],
            [
                '$group' => [
                    '_id' => '$_id',
                    'channelId' => [
                        '$first' => '$channelId'
                    ],
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
                    'channelId' => [
                        '$first' => '$channelId'
                    ],
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
                    'channelId' => 1,
                    'weight' => [
                        '$round' => [
                            [
                                '$divide' => ['$likes', '$dislikes']
                            ],
                            2
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