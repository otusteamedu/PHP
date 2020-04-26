<?php


namespace Model;

use JsonSerializable;

class Video implements JsonSerializable
{
    private int $id;

    private string $title;

    private string $videoId;

    private int $likes;

    private int $dislikes;

    private int $channelsId;

    public function __construct(
        int $id,
        string $title,
        string $videoId,
        int $likes,
        int $dislikes,
        int $channelsId
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->videoId = $videoId;
        $this->likes = $likes;
        $this->dislikes = $dislikes;
        $this->channelsId = $channelsId;
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

    public function getVideoId(): string
    {
        return $this->videoId;
    }

    public function setVideoId(string $videoId): self
    {
        $this->videoId = $videoId;
        return $this;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;
        return $this;
    }

    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    public function setDislikes(int $dislikes): self
    {
        $this->dislikes = $dislikes;
        return $this;
    }

    public function getChannelsId(): int
    {
        return $this->channelsId;
    }

    public function setChannelsId(int $channelsId): self
    {
        $this->channelsId = $channelsId;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'videoId' => $this->getVideoId(),
            'likes' => $this->getLikes(),
            'dislikes' => $this->getDislikes(),
        ];
    }

}