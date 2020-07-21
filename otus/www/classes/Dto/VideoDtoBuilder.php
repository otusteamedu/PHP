<?php

namespace Classes\Dto;

class VideoDtoBuilder
{

    private $errors = [];

    private $videoName;
    private $videoId;
    private $chanelId;
    private $videoLikeCount;
    private $videoDislikeCount;

    public function setVideoName(?string $videoName)
    {
        $this->videoName = $videoName;
        return $this;
    }

    public function setVideoId(?string $videoId)
    {
        $this->videoId = $videoId;
        return $this;
    }

    public function setChannelId(?string $channelId)
    {
        $this->chanelId = $channelId;
        return $this;
    }

    public function setVideoLikeCount(?int $likeCount)
    {
        $this->videoLikeCount = $likeCount;
        return $this;
    }

    public function setVideoDislikeCount(?int $dislikeCount)
    {
        $this->videoDislikeCount = $dislikeCount;
        return $this;
    }

    public function build()
    {
        $this->validate();

        if (!empty($this->errors)) {
            throw new \RuntimeException(implode(';', $this->errors));
        }
        return VideoDto::build($this);
    }

    public function validate()
    {
        if (empty($this->videoName)) {
            $this->errors[] = 'Не задано имя видео';
        }

        if (empty($this->videoId)) {
            $this->errors[] = 'Не задан id видео';
        }

        if (empty($this->chanelId)) {
            $this->errors[] = 'Не задан id канала';
        }

        if (empty($this->videoLikeCount)) {
            $this->errors[] = 'Не задано количество лайков';
        }

        if (empty($this->videoDislikeCount)) {
            $this->errors[] = 'Не задано количество дислайков';
        }

    }

    public function getVideoName()
    {
        return $this->videoName;
    }

    public function getVideoId()
    {
        return $this->videoId;
    }

    public function getChannelId()
    {
        return $this->chanelId;
    }

    public function getVideoLikeCount()
    {
        return $this->videoLikeCount;
    }

    public function getVideoDislikeCount()
    {
        return $this->videoDislikeCount;
    }
}
