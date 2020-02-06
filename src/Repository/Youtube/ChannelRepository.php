<?php declare(strict_types=1);

namespace Repository\Youtube;

use Repository\AbstractRepository;
use Service\Database\DatabaseInterface;

class ChannelRepository extends AbstractRepository
{
    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database, 'youtube-channels');
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
}
