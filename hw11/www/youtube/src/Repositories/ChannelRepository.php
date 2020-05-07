<?php

namespace App\Repositories;

use App\DB\MongoDB;
use App\Models\Channel;
use MongoDB\Collection;

class ChannelRepository
{
    /**
     * @var Collection
     */
    private Collection $collection;

    public function __construct()
    {
        $database = new MongoDB();
        $database->setCollectionName('channels');
        $this->collection = $database->getCollection();
    }

    public function find()
    {
        return $this->collection->find()->toArray();
    }
    /**
     * @param Channel[] $channels
     * @return $this
     */
    public function insertMany(array $channels): ChannelRepository
    {
        $this->collection->insertMany($channels);
        return $this;
    }

    public function deleteAll()
    {
        $this->collection->deleteMany([]);
        return $this;
    }

    public function getStatisticsSum()
    {
        $data = $this->collection->aggregate([
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
            ],
            [
                '$sort' => [
                    'likes' => -1
                ]
            ]
        ]);

        return $data->toArray();
    }

    public function getTopChannels($limit)
    {
        $data = $this->collection->aggregate([
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
                    'ratio' => [
                        '$round' => [
                            [
                                '$divide' => ['$likes', '$dislikes']
                            ],
                            0
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

        return $data->toArray();
    }
}