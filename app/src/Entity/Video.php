<?php

namespace App\Entity;

/**
 * Class Video
 */
class Video
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $likeCount;

    /**
     * @var int
     */
    private $dislikeCount;

    /**
     * @var string
     */
    private $channelId;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Video
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Video
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

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
     * @return Video
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

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
     * @return Video
     */
    public function setLikeCount(int $likeCount): self
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
     * @return Video
     */
    public function setDislikeCount(int $dislikeCount): self
    {
        $this->dislikeCount = $dislikeCount;

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
     * @return Video
     */
    public function setChannelId(string $channelId): self
    {
        $this->channelId = $channelId;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            '_id' => $this->getId(),
            'url' => $this->getUrl(),
            'title' => $this->getTitle(),
            'likeCount' => $this->getLikeCount(),
            'dislikeCount' => $this->getDislikeCount(),
            'channelId' => $this->getChannelId(),
        ];
    }
}
