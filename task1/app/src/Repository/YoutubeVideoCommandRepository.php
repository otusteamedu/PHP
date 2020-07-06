<?php


namespace App\Repository;


use App\Database\MongoManager;
use App\Models\YoutubeVideo;

class YoutubeVideoCommandRepository extends MongoManager
{
    protected $collectionName = 'youtubeVideos';

    public function create($fetchData)
    {
        $video = new YoutubeVideo();
        $video->title = $fetchData->snippet->title;
        $video->description = $fetchData->snippet->description;
        $video->channelTitle = $fetchData->snippet->channelTitle;
        $video->dislikeCount = $fetchData->statistics->dislikeCount;
        $video->likeCount = $fetchData->statistics->likeCount;
        $video->viewCount = $fetchData->statistics->viewCount;

        $this->collection->insertOne($video);

        return $video;
    }

    public function delete($param)
    {
        $this->collection->findOneAndDelete($param);

        return true;
    }

}