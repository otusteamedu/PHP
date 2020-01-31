<?php

namespace Filter;

class YoutubeChannelsFilter extends MongoFilter
{
    public const LIMIT = "limit";
    public const HASH_ID = "hashId";

    /** @var string $hashId */
    protected string $hashId = "";

    /** @var int $limit */
    protected int $limit = 0;

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
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }
}