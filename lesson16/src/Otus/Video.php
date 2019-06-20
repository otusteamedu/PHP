<?php

namespace Otus;

/**
 * Class Video
 * @package Otus
 */
class Video extends BaseRecord
{
    /**
     * Collection name in Mongo
     * @var string
     */
    protected static $collectionName = 'video';

    /**
     * Fields
     * @var array
     */
    protected static $fields = ['_id', 'categoryId', 'channelId', 'channelTitle', 'description', 'tags', 'publishedAt', 'statistics'];


    /**
     * Set data in properties from youtube api
     * @param $data
     */
    public function fromYouTubeData($data)
    {
        $this->setID($data->id);
        $this->setPublishedAt(isset($data->snippet->publishedAt) ? $data->snippet->publishedAt : null);
        $this->setChannelId(isset($data->snippet->channelId) ? $data->snippet->channelId : '');
        $this->setTitle(isset($data->snippet->title) ? $data->snippet->title : '');
        $this->setDescription(isset($data->snippet->description) ? $data->snippet->description : '');
        $this->setChannelTitle(isset($data->snippet->channelTitle) ? $data->snippet->channelTitle : '');
        $this->setTags(isset($data->snippet->tags) ? $data->snippet->tags : []);
        $this->setCategoryId(isset($data->snippet->categoryId) ? (int)$data->snippet->categoryId : null);
        $statistics = null;
        if (isset($data->statistics)) {
            $statistics = $data->statistics;
            isset($statistics->viewCount) ? ($statistics->viewCount = (int)$statistics->viewCount) : 0;
            isset($statistics->likeCount) ? ($statistics->likeCount = (int)$statistics->likeCount) : 0;
            isset($statistics->dislikeCount) ? ($statistics->dislikeCount = (int)$statistics->dislikeCount) : 0;
            isset($statistics->commentCount) ? ($statistics->commentCount = (int)$statistics->commentCount) : 0;
        }
        $this->setStatistics($statistics);
    }
}