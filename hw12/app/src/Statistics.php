<?php
/**
* Class for work with Youtube channels statisitcs
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
namespace Jekys;

class Statistics
{
    /**
    * @var object - manager for database connection
    */
    private $dbConn;

    /**
    * @var string - database name
    */
    private $dbName;

    /**
    * @var string - mongo database collection
    */
    private $dbCollection;

    /**
    * Object entity constructor
    *
    * @param string $dbHost - database hostname
    * @param int $dbPort - database port
    * @param string $dbName - database name
    *
    * @return void
    */
    public function __construct(String $dbHost, Int $dbPort, String $dbName, String $dbCollection)
    {
        $this->dbConn = new \MongoDB\Driver\Manager('mongodb://'.$dbHost.':'.$dbPort);
        $this->dbName = $dbName;
        $this->dbCollection = $dbCollection;
    }

    /**
    * Insert data to the collection
    *
    * @param array $data
    *
    * @return bool
    */
    public function insertData(array $data): bool
    {
        $bulk = new \MongoDB\Driver\BulkWrite;
        $bulk->insert($data);

        $result = $this->dbConn->executeBulkWrite($this->dbName.'.'.$this->dbCollection, $bulk);

        if ($result && $result->getInsertedCount() > 0) {
            return true;
        }

        return false;
    }

    /**
    * Returns summary likes and dislikes for the channel
    *
    * @param string $channelId
    *
    * @return array
    */
    public function getByChannel(String $channelId): array
    {
        $command = new \MongoDB\Driver\Command([
            'aggregate' => $this->dbCollection,
            'pipeline' => [
                [
                    '$match' => [
                        'youtube_id' => $channelId
                    ],
                ],
                ['$unwind' => '$videos'],
                [
                    '$group' => [
                        '_id' => null,
                        'likes' => [
                            '$sum' => '$videos.stats.likeCount'
                        ],
                        'dislikes' => [
                            '$sum' => '$videos.stats.dislikeCount'
                        ],
                    ]
                ]
            ],
            'cursor' => new \stdClass
        ]);

        $data = $this->dbConn->executeCommand($this->dbName, $command)->toArray();
        $stats = current($data);

        return [
            'likes' => $stats->likes,
            'dislikes' => $stats->dislikes
        ];
    }

    /**
    * Returns top N channels with best likes/dislikes ratio
    *
    * @param int $num
    *
    * @return array
    */
    public function getTopChannels(int $num): array
    {
        $command = new \MongoDB\Driver\Command([
            'aggregate' => $this->dbCollection,
            'pipeline' => [
                ['$unwind' => '$videos'],
                [
                    '$group' => [
                        '_id' => '$youtube_id',
                        'title' => [
                            '$addToSet' => '$title'
                        ],
                        'likes' => [
                            '$sum' => '$videos.stats.likeCount'
                        ],
                        'dislikes' => [
                            '$sum' => '$videos.stats.dislikeCount'
                        ],
                    ]
                ],
                [
                    '$project' => [
                        'title' => [
                            '$arrayElemAt' => ['$title', 0]
                        ],
                        'ratio' => [
                            '$divide' => ['$likes', '$dislikes']
                        ]
                    ]
                ],
                [
                    '$sort' => [
                        'ratio' => -1
                    ]
                ],
                ['$limit' => $num]
            ],
            'cursor' => new \stdClass
        ]);

        $data = $this->dbConn->executeCommand($this->dbName, $command)->toArray();

        $result = [];

        foreach ($data as $item) {
            $result[] = [
                'channel_id' => $item->_id,
                'title' => $item->title,
                'ratio' => round($item->ratio, 2),
            ];
        }

        return $result;
    }
}
