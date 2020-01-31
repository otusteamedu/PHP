<?php

namespace Entity;

use MongoDB\Model\BSONDocument;

class YoutubeChannelStatistics
{
    private string $id = "";
    private int $likesCount = 0;
    private int $dislikesCount = 0;
    private float $rating = 0.0;
    private YoutubeChannel $channel;

    public function __construct(BSONDocument $document)
    {
        $this->likesCount = $document['likesCount'];
        $this->dislikesCount = $document['dislikesCount'];
        $this->rating = floatval($document['rating']);
        $this->channel = new YoutubeChannel("{$document['_id']}");
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int|mixed
     */
    public function getLikesCount()
    {
        return $this->likesCount;
    }

    /**
     * @return int|mixed
     */
    public function getDislikesCount()
    {
        return $this->dislikesCount;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->rating;
    }

    /**
     * @return YoutubeChannel
     */
    public function getChannel(): YoutubeChannel
    {
        return $this->channel;
    }
}