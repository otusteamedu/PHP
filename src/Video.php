<?php

namespace crazydope\youtube;

class Video implements VideoInterface
{
    protected $id = '';

    protected $channelId = '';

    protected $title = '';

    protected $link = '';

    protected $likeCount = 0;

    protected $dislikeCount = 0;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return VideoInterface
     */
    public function setId(string $id): VideoInterface
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * @param string $channelId
     * @return VideoInterface
     */
    public function setChannelId(string $channelId): VideoInterface
    {
        $this->channelId = $channelId;
        return $this;
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
     * @return VideoInterface
     */
    public function setTitle(string $title): VideoInterface
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return VideoInterface
     */
    public function setLink(string $link): VideoInterface
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return int
     */
    public function getLikeCount(): int
    {
        return $this->likeCount;
    }

    /**
     * @param int $likeCount
     * @return VideoInterface
     */
    public function setLikeCount(int $likeCount): VideoInterface
    {
        $this->likeCount = $likeCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getDislikeCount(): int
    {
        return $this->dislikeCount;
    }

    /**
     * @param int $dislikeCount
     * @return VideoInterface
     */
    public function setDislikeCount(int $dislikeCount): VideoInterface
    {
        $this->dislikeCount = $dislikeCount;
        return $this;
    }

    public function exchangeArray( array $data): void
    {
        $this->id = $data['_id'] ? (string) $data['_id'] : '';
        $this->title = $data['title'] ?? '';
        $this->link = $data['link'] ?? '';
        $this->likeCount = $data['likeCount'] ?? '';
        $this->dislikeCount = $data['dislikeCount'] ?? '';
        $this->channelId = $data['channelId'] ?? '';
    }

    public function toArray(): array
    {
        return [
            'channelId' => $this->channelId,
            'title' => $this->title,
            'link' => $this->link,
            'likeCount' => $this->likeCount,
            'dislikeCount' => $this->dislikeCount
        ];
    }
}