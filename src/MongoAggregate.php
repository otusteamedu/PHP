<?php

namespace App;

use Traversable;

trait MongoAggregate
{
    private function aggregate(string $collection, array $pipeline): Traversable
    {
        $this->init();
        return $this->database->$collection->aggregate($pipeline);
    }

    /** @noinspection PhpUnused */
    public function getTopChannels(int $limit): Traversable
    {
        $pipe = [
            [
                '$group' => [
                    '_id' => '$channelId',
                    'like' => [
                        '$sum' => ['$convert' => ['input' => '$statistics.likeCount', 'to' => 'int']],
                    ],
                    'dislike' => [
                        '$sum' => ['$convert' => ['input' => '$statistics.dislikeCount', 'to' => 'int']],
                    ],
                ],
            ],
            [
                '$project' => [
                    'channelId' => '$_id',
                    'ratio' => ['$divide' => ['$like', ['$cond' => ['$dislike', '$dislike', 1]]]],
                    '_id' => 0,
                ],
            ],
            [
                '$sort' => [
                    'ratio' => -1,
                ],
            ],
            [
                '$limit' => $limit,
            ],
            [
                '$lookup' => [
                    'from' => 'channel',
                    'localField' => 'channelId',
                    'foreignField' => '_id',
                    'as' => 'channel',
                ],
            ],
            [
                '$project' => [
                    'channel' => ['$arrayElemAt' => ['$channel', 0]],
                    'ratio' => '$ratio',
                ],
            ],
            [
                '$project' => [
                    'channel' => '$channel.title',
                    'ratio' => '$ratio',
                ],
            ],
        ];
        return $this->aggregate('video', $pipe);
    }

    /** @noinspection PhpUnused */
    public function getChannelLikes(string $id): Traversable
    {
        $pipe = [
            [
                '$match' => ['channelId' => $id],
            ],
            [
                '$group' => [
                    '_id' => '$channelId',
                    'like' => [
                        '$sum' => ['$convert' => ['input' => '$statistics.likeCount', 'to' => 'int']],
                    ],
                    'dislike' => [
                        '$sum' => ['$convert' => ['input' => '$statistics.dislikeCount', 'to' => 'int']],
                    ],
                ],
            ],
            [
                '$project' => [
                    'like' => '$like',
                    'dislike' => '$dislike',
                    '_id' => 0,
                ],
            ],
        ];
        return $this->aggregate('video', $pipe);
    }
}
