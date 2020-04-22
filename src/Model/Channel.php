<?php


namespace Model;

use JsonSerializable;

class Channel implements JsonSerializable
{
    private string $title;

    private string $channelId;

    private array $videos;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function setChannelId(string $channelId): self
    {
        $this->channelId = $channelId;
        return $this;
    }

    public function getVideos(): array
    {
        return $this->videos;
    }

    public function setVideos(array $videos): self
    {
        $this->videos = $videos;
        return $this;
    }

    public function handleArray(array $channel): void
    {
        $this->setTitle($channel['title']);
        $this->setChannelId($channel['channelId']);

        $videos = [];
        foreach ($channel['videos'] as $item) {
            $video = new Video();
            $video->handleArray($item);
            $videos[] = $video;
        }
        $this->setVideos($videos);
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