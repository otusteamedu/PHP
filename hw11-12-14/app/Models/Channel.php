<?php

namespace App\Models;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Channel extends BaseModel
{
    private const INDEX = 'channels';
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string|null
     */
    private ?string $title;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @var string|null
     */
    private ?string $publishedAt;

    /**
     * @var int|null
     */
    private ?int $viewCount;

    /**
     * @var int|null
     */
    private ?int $subscriberCount;

    /**
     * @var int|null
     */
    private ?int $videoCount;

    /**
     * @var int|null
     */
    private ?int $likes = null;

    /**
     * @var int|null
     */
    private ?int $dislikes = null;

    /**
     * @var float|null
     */
    private ?float $likesAndDislikesRatio = null;

    /**
     * @var string[]
     */
    private ?array $videoIds;

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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     *
     * @return $this
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPublishedAt(): ?string
    {
        return $this->publishedAt;
    }

    /**
     * @param string|null $publishedAt
     *
     * @return $this
     */
    public function setPublishedAt(?string $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

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
    public function getSubscriberCount(): ?int
    {
        return $this->subscriberCount;
    }

    /**
     * @param int|null $subscriberCount
     *
     * @return $this
     */
    public function setSubscriberCount(?int $subscriberCount): self
    {
        $this->subscriberCount = $subscriberCount;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getVideoCount(): ?int
    {
        return $this->videoCount;
    }

    /**
     * @param int|null $videoCount
     *
     * @return $this
     */
    public function setVideoCount(?int $videoCount): self
    {
        $this->videoCount = $videoCount;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getVideoIds(): ?array
    {
        return $this->videoIds;
    }

    /**
     * @param array|null $videoIds
     *
     * @return $this
     */
    public function setVideoIds(?array $videoIds): self
    {
        $this->videoIds = $videoIds;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getLikesNumber(): ?int
    {
        return $this->likes;
    }

    /**
     * @param int|null $likes
     *
     * @return $this
     */
    public function setLikesNumber(?int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDislikesNumber(): ?int
    {
        return $this->dislikes;
    }

    /**
     * @param int|null $dislikes
     *
     * @return $this
     */
    public function setDislikesNumber(?int $dislikes): self
    {
        $this->dislikes = $dislikes;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getLikesAndDislikesRatio(): ?float
    {
        return $this->likesAndDislikesRatio;
    }

    /**
     * @param float|null $likesAndDislikesRatio
     *
     * @return $this
     */
    public function setLikesAndDislikesRatio(?float $likesAndDislikesRatio): self
    {
        $this->likesAndDislikesRatio = $likesAndDislikesRatio;

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
     * @return string
     */
    public static function getIndexStatic(): string
    {
        return self::INDEX;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'publishedAt' => $this->getPublishedAt(),
            'viewCount' => $this->getViewCount(),
            'subscriberCount' => $this->getSubscriberCount(),
            'videoCount' => $this->getVideoCount(),
            'videoIds' => $this->getVideoIds(),
            'likes' => $this->getLikesNumber(),
            'dislikes' => $this->getDislikesNumber(),
            'likesAndDislikesRatio' => $this->getLikesAndDislikesRatio(),
        ];
    }
}
