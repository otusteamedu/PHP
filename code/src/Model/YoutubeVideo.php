<?php


namespace App\Model;


use App\Model\Interfaces\BuilderElasticsearchInterface;
use App\Model\Builders\YoutubeVideoBuilder;
use App\Model\Interfaces\ModelElasticsearchInterface;

class YoutubeVideo extends YoutubeAbstractModel implements ModelElasticsearchInterface
{
    private string $channelId;
    private array $tags;

    private int $viewCount;
    private int $likeCount;
    private int $dislikeCount;
    private int $favoriteCount;
    private int $commentCount;

    public function getSearchIndex(): string
    {
        return 'video_index';
    }

    public function getSearchArray(): array
    {
        return get_object_vars($this);
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
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
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

    public function getSearchFields(): array
    {
        return [
            'title^2',
            'description',
            'tags^2'
        ];
    }

    public function getBuilder(): BuilderElasticsearchInterface
    {
        return new YoutubeVideoBuilder();
    }
}
