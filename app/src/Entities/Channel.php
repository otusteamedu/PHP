<?php

namespace App\Entities;

use Illuminate\Support\Collection;

class Channel extends BaseEntity
{
    private string $title = '';
    private string $description = '';
    private int $subscribersCount = 0;
    private int $videosCount = 0;
    private int $viewsCount = 0;
    private int $videoLikeCont = 0;
    private int $videoDislikeCont = 0;
    private float $videoLikesByDislikesQuotient = 0;

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
     * @var Collection | Video[]
     */
    private Collection $videos;

    public function __construct()
    {
        $this->videos = collect();
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
    public function getSubscribersCount(): int
    {
        return $this->subscribersCount;
    }

    /**
     * @param int $subscribersCount
     */
    public function setSubscribersCount(int $subscribersCount): void
    {
        $this->subscribersCount = $subscribersCount;
    }

    /**
     * @return int
     */
    public function getVideosCount(): int
    {
        return $this->videosCount;
    }

    /**
     * @param int $videosCount
     */
    public function setVideosCount(int $videosCount): void
    {
        $this->videosCount = $videosCount;
    }

    /**
     * @return int
     */
    public function getViewsCount(): int
    {
        return $this->viewsCount;
    }

    /**
     * @param int $viewsCount
     */
    public function setViewsCount(int $viewsCount): void
    {
        $this->viewsCount = $viewsCount;
    }

    /**
     * @return string
     */
    public function getIndexId(): string
    {
        return $this->indexId;
    }

    /**
     * @param string $indexId
     */
    public function setIndexId(string $indexId): void
    {
        $this->indexId = $indexId;
    }

    /**
     * @return Video[]|Collection
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    /**
     * @param Video[]|Collection $videos
     */
    public function setVideos(Collection $videos): void
    {
        $this->videos = $videos;
    }

    /**
     * @return int
     */
    public function getVideoLikeCont(): int
    {
        return $this->videoLikeCont;
    }

    /**
     * @param int $videoLikeCont
     */
    public function setVideoLikeCont(int $videoLikeCont): void
    {
        $this->videoLikeCont = $videoLikeCont;
    }

    /**
     * @return int
     */
    public function getVideoDislikeCont(): int
    {
        return $this->videoDislikeCont;
    }

    /**
     * @param int $videoDislikeCont
     */
    public function setVideoDislikeCont(int $videoDislikeCont): void
    {
        $this->videoDislikeCont = $videoDislikeCont;
    }

    /**
     * @return float
     */
    public function getVideoLikesByDislikesQuotient(): float
    {
        return $this->videoLikesByDislikesQuotient;
    }

    /**
     * @param float $videoLikesByDislikesQuotient
     */
    public function setVideoLikesByDislikesQuotient(float $videoLikesByDislikesQuotient): void
    {
        $this->videoLikesByDislikesQuotient = $videoLikesByDislikesQuotient;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'subscribersCount' => $this->subscribersCount,
            'videosCount' => $this->videosCount,
            'viewsCount' => $this->viewsCount,
        ];
    }


}