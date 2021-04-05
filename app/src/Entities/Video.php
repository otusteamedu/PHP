<?php


namespace App\Entities;


use Carbon\Carbon;

class Video extends BaseEntity
{
    private string $channelId = '';
    private string $title = '';
    private string $description = '';
    private int $likeCount = 0;
    private int $dislikeCount = 0;
    private int $viewCount = 0;
    private int $favoriteCount = 0;
    private int $commentCount = 0;
    private ?Carbon $publishedAt = null;
    private Channel $channel;

    protected ?string $id = null;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
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
     */
    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
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
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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
     */
    public function setLikeCount(int $likeCount): void
    {
        $this->likeCount = $likeCount;
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
     */
    public function setDislikeCount(int $dislikeCount): void
    {
        $this->dislikeCount = $dislikeCount;
    }

    /**
     * @return int
     */
    public function getViewCount(): int
    {
        return $this->viewCount;
    }

    /**
     * @param int $viewCount
     */
    public function setViewCount(int $viewCount): void
    {
        $this->viewCount = $viewCount;
    }

    /**
     * @return int
     */
    public function getFavoriteCount(): int
    {
        return $this->favoriteCount;
    }

    /**
     * @param int $favoriteCount
     */
    public function setFavoriteCount(int $favoriteCount): void
    {
        $this->favoriteCount = $favoriteCount;
    }

    /**
     * @return int
     */
    public function getCommentCount(): int
    {
        return $this->commentCount;
    }

    /**
     * @param int $commentCount
     */
    public function setCommentCount(int $commentCount): void
    {
        $this->commentCount = $commentCount;
    }

    /**
     * @return Carbon
     */
    public function getPublishedAt(): Carbon
    {
        return $this->publishedAt;
    }

    /**
     * @param string $publishedAt
     */
    public function setPublishedAt(string $publishedAt): void
    {
        $this->publishedAt = Carbon::parse($publishedAt);
    }

    /**
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * @param Channel $channel
     */
    public function setChannel(Channel $channel): void
    {
        $this->channel = $channel;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'channelId' => $this->channelId,
            'title' => $this->title,
            'description' => $this->description,
            'commentCount' => $this->commentCount,
            'favoriteCount' => $this->favoriteCount,
            'viewCount' => $this->viewCount,
            'dislikeCount' => $this->dislikeCount,
            'likeCount' => $this->likeCount,
            'publishedAt' => $this->publishedAt->toDateString(),
        ];
    }
}