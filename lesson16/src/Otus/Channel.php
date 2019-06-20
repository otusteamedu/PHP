<?php

namespace Otus;

/**
 * Class Channel
 * @package Otus
 */
class Channel extends BaseRecord
{
    /**
     * Collection name in Mongo
     * @var string
     */
    protected static $collectionName = 'channel';

    /**
     * Fields
     * @var array
     */
    protected static $fields = ['_id', 'title', 'description', 'customUrl', 'publishedAt', 'country', 'uploads', 'statistics'];

    /**
     * Set data in properties from youtube api
     * @param $data
     */
    public function fromYouTubeData($data)
    {
        $this->setID($data->id);
        $this->setTitle(isset($data->snippet->title) ? $data->snippet->title : '');
        $this->setDescription(isset($data->snippet->description) ? $data->snippet->description : '');
        $this->setCustomUrl(isset($data->snippet->customUrl) ? $data->snippet->customUrl : '');
        $this->setPublishedAt(isset($data->snippet->publishedAt) ? $data->snippet->publishedAt : null);
        $this->setCountry(isset($data->snippet->country) ? $data->snippet->country : '');
        $this->setUploads(isset($data->contentDetails->relatedPlaylists->uploads) ? $data->contentDetails->relatedPlaylists->uploads : null);
        $statistics = null;
        if (isset($data->statistics)) {
            $statistics = $data->statistics;
            isset($statistics->viewCount) ? ($statistics->viewCount = (int)$statistics->viewCount) : 0;
            isset($statistics->commentCount) ? ($statistics->commentCount = (int)$statistics->commentCount) : 0;
            isset($statistics->subscriberCount) ? ($statistics->subscriberCount = (int)$statistics->subscriberCount) : 0;
            isset($statistics->hiddenSubscriberCount) ? ($statistics->hiddenSubscriberCount = filter_var($statistics->hiddenSubscriberCount, FILTER_VALIDATE_BOOLEAN)) : false;
            isset($statistics->videoCount) ? ($statistics->videoCount = (int)$statistics->videoCount) : 0;
        }
        $this->setStatistics($statistics);
    }

}