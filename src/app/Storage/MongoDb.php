<?php

declare(strict_types=1);

namespace app\Storage;

use app\{Channel, Stats, Video};
use MongoDB\Client;
use MongoDB\Driver\Command;
use app\Channel\Collection as ChannelCollection;

class MongoDb implements StorageInterface
{
    const PORT_DEFAULT = 27017;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $db;

    /**
     * @var string
     */
    private $collection;

    public function __construct(array $config)
    {
        $port = $config['port'] ?? self::PORT_DEFAULT;
        $this->client = new Client('mongodb://' . $config['host'] . ':' . $port);
        $this->db = $config['db'];
        $this->collection = $config['collection'];

        //$this->client->selectDatabase($this->db);
        $this->client->selectCollection($this->db, $this->collection);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function insertChannel(Channel $channel): bool
    {
        $result = $this->client->selectCollection($this->db, $this->collection)->insertOne($channel->toArray());
        return $result->getInsertedCount() === 1;
    }


    /**
     * @param int $limit
     * @return ChannelCollection
     */
    public function getTopChannels(int $limit): ChannelCollection
    {
        $command = new Command([
            'aggregate' => $this->collection,
            'pipeline' => [
                [
                    '$unwind' => '$videos'
                ],
                [
                    '$group' => [
                        '_id' => '$id',
                        'title' => [
                            '$addToSet' => '$title'
                        ],
                        'videos' => [
                            '$addToSet' => '$videos'
                        ],
                        'likes' => [
                            '$sum' => '$videos.likes',
                        ],
                        'dislikes' => [
                            '$sum' => '$videos.dislikes'
                        ]
                    ],
                ],
                [
                    '$project' => [
                        'likes' => '$likes',
                        'dislikes' => '$dislikes',
                        'ratio' => [
                            '$divide' => [
                                '$dislikes', '$likes'
                            ]
                        ],
                        'title' => [
                            '$arrayElemAt' => ['$title', 0]
                        ],
                        'videos' => '$videos',
                    ]
                ],
                [
                    '$sort' => [
                        'ratio' => -1
                    ]
                ],
                [
                    '$limit' => $limit
                ]
            ],
            'cursor' => new \stdClass()
        ]);

        $result = $this->getClient()->getManager()->executeCommand($this->db, $command)->toArray();

        $collection = new ChannelCollection();
        if ($result) {
            foreach ($result as $item) {
                $channel = new Channel($item->_id, $item->title);
                if (!empty($item->videos)) {
                    foreach ($item->videos as $videoParams) {
                        $video = new Video([
                            'id' => $videoParams->id,
                            'title' => $videoParams->title,
                            'duration' => (int) $videoParams->duration,
                            'stats' => new Stats(
                                (int) $videoParams->likes,
                                (int) $videoParams->dislikes,
                                (int) $videoParams->comments_count,
                                (int) $videoParams->views
                            ),
                            'publishedAt' => $videoParams->published_at
                        ]);
                        $channel->addVideo($video);
                    }
                }

                $collection->addChannel($channel);
            }
        }

        return $collection;
    }

    public function getChannelStats(string $channelId): Stats
    {
        $command = new Command([
            'aggregate' => $this->collection,
            'pipeline' => [
                [
                    '$match' => [
                        'id' => $channelId
                    ],
                ],
                [
                    '$unwind' => '$videos'
                ],
                [
                    '$group' => [
                        '_id' => null,
                        'likes' => [
                            '$sum' => '$videos.likes'
                        ],
                        'dislikes' => [
                            '$sum' => '$videos.dislikes'
                        ],
                    ]
                ]
            ],
            'cursor' => new \stdClass()
        ]);

        $result = $this->getClient()->getManager()->executeCommand($this->db, $command)->toArray();

        if (!empty($result)) {
            $rate = current($result);
            return new Stats($rate->likes, $rate->dislikes);
        }

        return new Stats();
    }
}