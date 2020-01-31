<?php

namespace Entity;

use MongoDB\Collection;
use Repository\MongoRepository;

class YoutubeChannel extends MongoRepository
{
    /**
     * @var Collection $collection
     */
    protected static Collection $collection;

    /**
     * @var array $indexes
     */
    protected static array $indexes = [
        ['key' => ["hashId" => 1], 'unique' => true],
    ];

    protected string $title = "";
    protected string $hashId = "";
    protected string $description = "";
    protected int $likesCount = 0;
    protected int $dislikesCount = 0;

    /**
     * @param int $limit
     * @return YoutubeChannelStatistics[]
     */
    public static function getTopChannelsStatistics(int $limit): array
    {
        $rows = static::$collection->aggregate([
            [
                '$group' => [
                    '_id'           => '$_id',
                    'likesCount'    => ['$max' => '$likesCount'],
                    'dislikesCount' => ['$max' => '$dislikesCount'],
                ],
            ],
            [
                '$addFields' => [
                    'rating' => ['$multiply' => [100, ['$divide' => ['$likesCount', ['$sum' => ['$likesCount', '$dislikesCount']]]]]],
                ],
            ],
            [
                '$sort' => ['rating' => -1],
            ],
            [
                '$limit' => $limit,
            ],
        ])->toArray();
        return array_map(function ($row) {
            return new YoutubeChannelStatistics($row);
        }, $rows);
    }

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

    /**
     * @return string|null
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
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
     * @param int $multiplier
     * @return float
     */
    public function getRate(int $multiplier = 1): float
    {
        $sum = $this->likesCount + $this->dislikesCount;
        if ($sum === 0) return 0;
        return ($this->likesCount / $sum) * $multiplier;
    }
}