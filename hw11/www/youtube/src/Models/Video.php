<?php


namespace App\Models;

/**
 * Class Video
 * @package App\Models
 */
class Video
{
    private string $title;
    private string $videoId;
    private int $likes = 0;
    private int $dislikes = 0;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getVideoId(): string
    {
        return $this->videoId;
    }

    public function setVideoId(string $videoId): void
    {
        $this->videoId = $videoId;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }

    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    public function setDislikes(int $dislikes): void
    {
        $this->dislikes = $dislikes;
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

    public function setVideoStatistics($statistics)
    {
        $this->setLikes($statistics['likes']);
        $this->setDislikes($statistics['dislikes']);
    }
}