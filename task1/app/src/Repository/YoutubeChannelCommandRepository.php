<?php


namespace App\Repository;


use App\Database\MongoManager;
use App\Models\YoutubeChannel;

class YoutubeChannelCommandRepository extends MongoManager
{
    protected $collectionName = 'youtubeChannels';

    public function create($fetchData, array $videoIds)
    {
        $channel = new YoutubeChannel();
        $channel->channelId = $fetchData->id;
        $channel->title = $fetchData->snippet->title;
        $channel->description = $fetchData->snippet->description;
        $channel->customUrl = $fetchData->snippet->customUrl;
        $channel->country = $fetchData->snippet->country;
        $channel->videoIds = $videoIds ?? [];
        $this->collection->insertOne($channel);

        return $channel;
    }

    public function delete($param)
    {
        $this->collection->findOneAndDelete($param);

        return true;
    }
}