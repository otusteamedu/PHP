<?php

namespace crazydope\youtube\db;

use crazydope\youtube\ChannelInterface;
use crazydope\youtube\ChannelStat;
use crazydope\youtube\db\adapter\MongoAdapterInterface;

class VideoStorage extends AbstractStorage implements VideoStatInterface
{
    /**
     * VideoStorage constructor.
     * @param MongoAdapterInterface $adapter
     * @param string $collection
     */
    public function __construct(MongoAdapterInterface $adapter, string $collection)
    {
        $this->adapter = $adapter;
        $this->collection = $collection;
    }

    /**
     * @param ChannelInterface $channel
     * @return string|null
     */
    public function getChannelVideoStats(ChannelInterface $channel): ?string
    {
        $cursor =  $this->aggregate([
            ['$match' => ['channelId' => $channel->getId()]],
            ['$group' => ['_id' => '$channelId', 'links' => ['$max' => '$likeCount'], 'dislikes' => ['$max' => '$dislikeCount']]]]
        );

        if(!$cursor instanceof \MongoDB\Driver\Cursor){
            return null;
        }

        $data = $cursor->toArray();

        if(!$data){
            return null;
        }

        if(!$data[0] instanceof \ArrayObject){
            return null;
        }
        return
            'Channel "'. $channel->getTitle() .
            '" Total likes: '. $data[0]->offsetGet('links') .
            ' Total dislikes: '. $data[0]->offsetGet('dislikes');
    }

    /**
     * @param GetChannelInterface $storage
     * @return array
     */
    public function getTopRatedChannels(GetChannelInterface $storage): array
    {
        $result = [];
        $cursor = $this->aggregate([
            ['$group' =>
                ['_id' => '$channelId',
                    'links' => ['$max' => '$likeCount'],
                    'dislikes' => ['$max' => '$dislikeCount'],
                ]
            ],
            [
                '$addFields' => [
                    'weight' => ['$divide' => ['$links', '$dislikes']]
                ]
            ],
            [
                '$sort' => [
                    'weight' => -1
                ]
            ]
        ]);

        if(!$cursor instanceof \MongoDB\Driver\Cursor){
            return [];
        }

        foreach ($cursor as $resultObject){

            if (!$resultObject instanceof \ArrayObject) {
                continue;
            }

            $channel = $storage->getChannelById($resultObject->offsetGet('_id'));

            $result[] = new ChannelStat(
                $channel->getTitle(),
                $resultObject->offsetGet('links'),
                $resultObject->offsetGet('dislikes'),
                $resultObject->offsetGet('weight')
            );
        }

        return $result;
    }
}