<?php


namespace App\Model\Youtube;


class DataMapper
{
    public function getChannel(\Google_Service_YouTube_Channel $channel): Channel
    {
        $model = new Channel();
        $model->setId($channel->getId());
        $model->setTitle($channel->getSnippet()->getTitle());
        $model->setDescription($channel->getSnippet()->getDescription());
        return $model;
    }

    public function getVideo(\Google_Service_YouTube_Video $video): Video
    {
        $model = new Video();
        $model->setId($video->getId());
        $model->setChannelId($video->getSnippet()->getChannelId());
        $model->setTitle($video->getSnippet()->getTitle());
        $model->setLikeCount((int)$video->getStatistics()->getLikeCount());
        $model->setDislikeCount((int)$video->getStatistics()->getDislikeCount());
        return $model;
    }
}