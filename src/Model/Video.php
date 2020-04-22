<?php


namespace Model;

use JsonSerializable;

class Video implements JsonSerializable
{
    private string $title;

    private string $videoId;

    private int $likes;

    private int $dislikes;

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

    public function handleArray(array $video): void
    {
        print_r($video);
        $this->setTitle($video['title']);
        $this->setVideoId($video['videoId']);
        $this->setLikes($video['likes'] ?? 0);
        $this->setDislikes($video['dislikes'] ?? 0);
    }

    public function jsonSerialize()
    {
        return [
            'title' => $this->getTitle(),
            'videoId' => $this->getVideoId(),
            'likes' => $this->getLikes(),
            'dislikes' => $this->getDislikes(),
        ];
    }

}