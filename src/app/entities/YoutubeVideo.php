<?php

namespace Entity;

use MongoDB\Collection;
use Repository\MongoRepository;

class YoutubeVideo extends MongoRepository
{
    /**
     * @var Collection $collection
     */
    protected static Collection $collection;

    protected static array $indexes = [
        ['key' => ["hashId" => 1], 'unique' => true],
        ['key' => ["channelId" => 1]],
    ];

    protected string $hashId = "";
    protected string $title = "";
    protected string $description = "";
    protected int $likesCount = 0;
    protected int $dislikesCount = 0;
    protected string $channelId = "";

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getLikesCount(): int
    {
        return $this->likesCount;
    }

    /**
     * @param int $likesCount
     */
    public function setLikesCount(int $likesCount): void
    {
        $this->likesCount = $likesCount;
    }

    /**
     * @return int
     */
    public function getDislikesCount(): int
    {
        return $this->dislikesCount;
    }

    /**
     * @param int $dislikesCount
     */
    public function setDislikesCount(int $dislikesCount): void
    {
        $this->dislikesCount = $dislikesCount;
    }

    /**
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * @param string $channelId
     */
    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }

    /**
     * @return string
     */
    public function getHashId(): string
    {
        return $this->hashId;
    }

    /**
     * @param string $hashId
     */
    public function setHashId(string $hashId): void
    {
        $this->hashId = $hashId;
    }
}