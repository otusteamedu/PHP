<?php


namespace Model;

use JsonSerializable;
use Closure;

class Channel implements JsonSerializable
{
    private int $id;

    private string $title;

    private string $channelId;

    private array $videos;

    private Closure $videosRef;

    public function __construct(
        int $id,
        string $title,
        string $channelId
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->channelId = $channelId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

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
        if (!isset($this->videos)) {
            $ref = $this->videosRef;
            $this->videos = $ref();
        }
        return $this->videos;
    }

    public function setVideos(Closure $videosRef): void
    {
        $this->videosRef = $videosRef;
    }

    public function jsonSerialize()
    {
        $channel = [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'channelId' => $this->getChannelId(),
        ];
        foreach ($this->getVideos() as $video) {
            $channel['videos'][] = $video->jsonSerialize();
        }

        return $channel;
    }

}