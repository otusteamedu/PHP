<?php

namespace App\Models;

class Channel implements \JsonSerializable
{
    private string $title;
    private string $channelId;
    /**
     * @var Video[];
     */
    private array $videos = [];

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }

    /**
     * @return Video[]
     */
    public function getVideos(): array
    {
        return $this->videos;
    }

    /**
     * @param Video[] $videos
     */
    public function setVideos(array $videos): void
    {
        $this->videos = $videos;
    }

    public function jsonSerialize()
    {
        $channel = [
            'title' => $this->getTitle(),
            'channelId' => $this->getChannelId(),
        ];
        foreach ($this->getVideos() as $video) {
            $channel['videos'][] = $video->jsonSerialize();
        }

        return $channel;
    }
}
