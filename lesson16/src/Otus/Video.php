<?php

namespace Otus;

class Video extends BaseRecord
{
    protected static $collectionName = 'video';


    public function fromYouTubeData($data)
    {
        $this->setID($data->id);
        $this->setPublishedAt($data->snippet->publishedAt);
        $this->setChannelId($data->snippet->channelId);
        $this->setTitle($data->snippet->title);
        $this->setDescription($data->snippet->description);
        $this->setChannelTitle($data->snippet->channelTitle);
        $this->setTags(isset($data->snippet->tags) ? $data->snippet->tags : []);
        $this->setCategoryId($data->snippet->categoryId);
        $this->setStatistics($data->statistics);
    }
}