<?php

namespace Filter;

class YoutubeVideosFilter extends MongoFilter
{
    public const CHANNEL_ID = "channelId";

    protected string $channelId = "";

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
}