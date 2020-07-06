<?php


namespace App\Repository;


use App\Database\MongoManager;
use App\Models\YoutubeChannel;

class YoutubeChannelQueryRepository extends MongoManager
{
    protected $collectionName = 'youtubeChannels';

    public function getById($channelId): ?YoutubeChannel
    {
        $findOneResult = $this->collection->findOne(['channelId' => $channelId]);
        if (!$findOneResult) {
            return null;
        }
        $channel = new YoutubeChannel();
        $channel->channelId = $findOneResult["channelId"];
        $channel->title = $findOneResult["title"];
        $channel->description = $findOneResult["description"];
        $channel->customUrl = $findOneResult["customUrl"];
        $channel->country = $findOneResult["country"];
        $channel->videoIds = $findOneResult['videoIds']->bsonSerialize();

        return $channel;
    }

    public function getByChannelName($channelName): ?YouTubeChannel
    {
        $findOneResult = $this->collection->findOne(['title' => $channelName]);
        if (!$findOneResult) {
            return null;
        }
        $channel = new YoutubeChannel();
        $channel->channelId = $findOneResult["channelId"];
        $channel->title = $findOneResult["title"];
        $channel->description = $findOneResult["description"];
        $channel->customUrl = $findOneResult["customUrl"];
        $channel->country = $findOneResult["country"];
        $channel->videoIds = $findOneResult['videoIds']->bsonSerialize();

        return $channel;
    }
}