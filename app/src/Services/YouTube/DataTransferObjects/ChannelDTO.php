<?php

namespace App\Services\YouTube\DataTransferObjects;

class ChannelDTO
{
    private string $id;
    private string $title = '';
    private string $description = '';
    private int $subscribersCount = 0;
    private int $videosCount = 0;
    private int $viewsCount = 0;
    private string $playsListItemsUploadsId = '';

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
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
    public function getPlaysListItemsUploadsId(): string
    {
        return $this->playsListItemsUploadsId;
    }

    /**
     * @param string $playsListItemsUploadsId
     */
    public function setPlaysListItemsUploadsId(string $playsListItemsUploadsId): void
    {
        $this->playsListItemsUploadsId = $playsListItemsUploadsId;
    }


}