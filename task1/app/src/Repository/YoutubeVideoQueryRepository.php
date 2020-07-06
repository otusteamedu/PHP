<?php


namespace App\Repository;


use App\Database\MongoManager;

class YoutubeVideoQueryRepository extends MongoManager
{
    protected $collectionName = 'youtubeVideos';

    public function getAllByName($channelName)
    {
        $findAll = $this->collection->find(['channelTitle' => $channelName])->toArray();
        if (!$findAll) {
            throw new \Exception('Видео не найдены');
        }
        $result = [];
        foreach ($findAll as $key => $video) {
            $result[] = $video->bsonSerialize();
        }
        return $result;
    }

    public function getChannels()
    {
        return $this->collection->distinct('channelTitle');
    }
}