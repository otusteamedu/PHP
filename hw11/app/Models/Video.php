<?php

namespace App\Models;

use JetBrains\PhpStorm\ArrayShape;

class Video extends BaseModel
{
    public const INDEX = 'videos';
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string|null
     */
    private ?string $duration;

    /**
     * @var int|null
     */
    private ?int $viewCount;

    /**
     * @var int|null
     */
    private ?int $likeCount;

    /**
     * @var int|null
     */
    private ?int $dislikeCount;

    /**
     * @var int|null
     */
    private ?int $favoriteCount;

    /**
     * @var int|null
     */
    private ?int $commentCount;

    /**
     * @var string|null
     */
    private ?string $channelId;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDuration(): ?string
    {
        return $this->duration;
    }

    /**
     * @param string|null $duration
     *
     * @return $this
     */
    public function setDuration(?string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getViewCount(): ?int
    {
        return $this->viewCount;
    }

    /**
     * @param int|null $viewCount
     *
     * @return $this
     */
    public function setViewCount(?int $viewCount): self
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getLikeCount(): ?int
    {
        return $this->likeCount;
    }

    /**
     * @param int|null $likeCount
     *
     * @return $this
     */
    public function setLikeCount(?int $likeCount): self
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDislikeCount(): ?int
    {
        return $this->dislikeCount;
    }

    /**
     * @param int|null $dislikeCount
     *
     * @return $this
     */
    public function setDislikeCount(?int $dislikeCount): self
    {
        $this->dislikeCount = $dislikeCount;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getFavoriteCount(): ?int
    {
        return $this->favoriteCount;
    }

    /**
     * @param int|null $favoriteCount
     *
     * @return $this
     */
    public function setFavoriteCount(?int $favoriteCount): self
    {
        $this->favoriteCount = $favoriteCount;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCommentCount(): ?int
    {
        return $this->commentCount;
    }

    /**
     * @param int|null $commentCount
     *
     * @return $this
     */
    public function setCommentCount(?int $commentCount): self
    {
        $this->commentCount = $commentCount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    /**
     * @param string|null $channelId
     *
     * @return $this
     */
    public function setChannelId(?string $channelId): self
    {
        $this->channelId = $channelId;

        return $this;
    }

    /**
     * @return string
     */
    public function getIndex(): string
    {
        return self::INDEX;
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "string", 'duration' => "string", 'viewCount' => "int", 'likeCount' => "int", 'dislikeCount' => "int", 'favoriteCount' => "int", 'commentCount' => "int", 'channelId' => "?string"])]
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'duration' => $this->getDuration(),
            'viewCount' => $this->getViewCount(),
            'likeCount' => $this->getLikeCount(),
            'dislikeCount' => $this->getDislikeCount(),
            'favoriteCount' => $this->getFavoriteCount(),
            'commentCount' => $this->getCommentCount(),
            'channelId' => $this->getChannelId(),
        ];
    }
}
