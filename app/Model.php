<?php
namespace Youtubestat;


class Model
{
    private $collection;

    public function __construct(Array $structure)
    {
        switch(count($structure)) {
            case 1:
                $this->collection = (new \MongoDB\Client)->{$structure[0]};
                break;
            case 2:
                $this->collection = (new \MongoDB\Client)->{$structure[0]}->{$structure[1]};
                break;
            case 3:
                $this->collection = (new \MongoDB\Client)->{$structure[0]}->{$structure[1]}->{$structure[2]};
                break;
            case 4:
                $this->collection = (new \MongoDB\Client)->{$structure[0]}->{$structure[1]}->{$structure[2]}->{$structure[3]};
                break;
            default:
        $this->collection = (new \MongoDB\Client)->youtube->channels;
        }
    }


    //add section
    public function addAll2Collection(Array $data)
    {
        $insertOneResult = $this->collection->insertMany($data);

        return $insertOneResult->getInsertedCount();
    }



    public function addItem2Collection(Array $data)
    {
        $insertOneResult = $this->collection->insertOne($data);

        return $insertOneResult->getInsertedCount();
    }
    //end add section


    //info section
    public function getAllData(Array $options = [])
    {
        $cursor = $this->collection->find(
            [],
            $options
        );

        return $cursor;
    }

    public function getChannelVideos($channelID = '')
    {
        if (empty($channelID)) {
            throw new \Exception('Missing or empty required parameter channel ID');
        }

        $jsonData = $this->collection->findOne(['channelId' => $channelID]);

        $result = [];
        if (!empty($jsonData)) {
            $result = json_decode($jsonData);
        }

        return $result;
    }
    //end info section


    // statistics section
    public function getChannelStat($channelID = '')
    {
        if (empty($channelID)) {
            throw new \Exception('Missing or empty required parameter channel ID');
        }

        return  $this->collection->aggregate([
            ['$match' => ["channelId" => $channelID] ],
            ['$unwind' => '$channelVideos'],
            ['$group' => [
                '_id' => null,
                'likes' => [
                    '$sum' => [
                        '$toDouble' => '$channelVideos.statistics.likeCount'
                    ]
                ],
                'disLikes' => [
                    '$sum' => [
                        '$toDouble' => '$channelVideos.statistics.dislikeCount'
                    ]
                ],
                'comments' => [
                    '$sum' => [
                        '$toDouble' => '$channelVideos.statistics.commentCount'
                    ]
                ],
                'view' => [
                    '$sum' => [
                        '$toDouble' => '$channelVideos.statistics.viewCount'
                    ]
                ]
            ]]
        ]);

    }


    public function getTopLikeDislikeChannels()
    {
        $topLikes = $this->collection->aggregate([
            ['$unwind' => '$channelVideos'],
            ['$project' => [
                '_id' => null,
                'channelId' => 1,
                'channelTitle' => 1,
                'likes' => [
                    '$sum' => [
                        '$toDouble' => '$channelVideos.statistics.likeCount'
                    ]
                ],
                'disLikes' => [
                    '$sum' => [
                        '$toDouble' => '$channelVideos.statistics.dislikeCount'
                    ]
                ],
                'comments' => [
                    '$sum' => [
                        '$toDouble' => '$channelVideos.statistics.commentCount'
                    ]
                ],
                'view' => [
                    '$sum' => [
                        '$toDouble' => '$channelVideos.statistics.viewCount'
                    ]
                ]
            ]
            ],
            ['$group' => [
                '_id' => ['channelId' => '$channelId', 'channelTitle' => '$channelTitle'],
                'likes' => [
                    '$sum' => [
                        '$toDouble' => '$likes'
                    ]
                ],
                'disLikes' => [
                    '$sum' => [
                        '$toDouble' => '$disLikes'
                    ]
                ],
                'comments' => [
                    '$sum' => [
                        '$toDouble' => '$comments'
                    ]
                ],
                'view' => [
                    '$sum' => [
                        '$toDouble' => '$view'
                    ]
                ]
            ]
            ],
            ['$sort' => ['likes' => -1]]
        ]);

        $topDislikes = $this->collection->aggregate([
        ['$unwind' => '$channelVideos'],
        ['$project' => [
            '_id' => null,
            'channelId' => 1,
            'channelTitle' => 1,
            'likes' => [
                '$sum' => [
                    '$toDouble' => '$channelVideos.statistics.likeCount'
                ]
            ],
            'disLikes' => [
                '$sum' => [
                    '$toDouble' => '$channelVideos.statistics.dislikeCount'
                ]
            ],
            'comments' => [
                '$sum' => [
                    '$toDouble' => '$channelVideos.statistics.commentCount'
                ]
            ],
            'view' => [
                '$sum' => [
                    '$toDouble' => '$channelVideos.statistics.viewCount'
                ]
            ]
        ]
        ],
        ['$group' => [
            '_id' => ['channelId' => '$channelId', 'channelTitle' => '$channelTitle'],
            'likes' => [
                '$sum' => [
                    '$toDouble' => '$likes'
                ]
            ],
            'disLikes' => [
                '$sum' => [
                    '$toDouble' => '$disLikes'
                ]
            ],
            'comments' => [
                '$sum' => [
                    '$toDouble' => '$comments'
                ]
            ],
            'view' => [
                '$sum' => [
                    '$toDouble' => '$view'
                ]
            ]
        ]
        ],
        ['$sort' => ['disLikes' => -1]]
    ]);

        return [$topLikes, $topDislikes];

    }
    //end statistics section


    //delete section
    public function deleteOneChannel(Array $data)
    {
        if (empty($data)) {
            throw new \Exception('Required parameter $data is empty');
        }


        $res = $this->collection->deleteOne($data);
        return $res->getDeletedCount();
    }

    public function deleteManyChannels(Array $data)
    {
        if (empty($data)) {
            throw new \Exception('Required parameter $data is empty');
        }


        $res = $this->collection->deleteMany($data);
        return $res->getDeletedCount();
    }
    //end delete sections
}