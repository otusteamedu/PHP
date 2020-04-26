<?php

namespace Bjlag\Entities\Dto;

use Bjlag\Dto;

class VideoDto implements Dto
{
    /** @var string */
    private $id;

    /** @var string */
    private $channelId;

    /** @var string */
    private $url;

    /** @var string */
    private $name;

    /** @var string */
    private $previewImage;

    /** @var string */
    private $description;

    /** @var string */
    private $category;

    /** @var string */
    private $duration;

    /** @var \DateTimeImmutable */
    private $postData;

    /** @var int */
    private $numberLike;

    /** @var int */
    private $numberDislike;

    /** @var int */
    private $numberViews;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return VideoDto
     */
    public function setId(?string $id): VideoDto
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
     * @return VideoDto
     */
    public function setChannelId(string $channelId): VideoDto
    {
        $this->channelId = $channelId;
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
     * @return VideoDto
     */
    public function setUrl(string $url): VideoDto
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return VideoDto
     */
    public function setName(string $name): VideoDto
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPreviewImage(): string
    {
        return $this->previewImage;
    }

    /**
     * @param string $previewImage
     * @return VideoDto
     */
    public function setPreviewImage(string $previewImage): VideoDto
    {
        $this->previewImage = $previewImage;
        return $this;
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
     * @return VideoDto
     */
    public function setDescription(string $description): VideoDto
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @return VideoDto
     */
    public function setCategory(string $category): VideoDto
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @param string $duration
     * @return VideoDto
     */
    public function setDuration(string $duration): VideoDto
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getPostData(): \DateTimeImmutable
    {
        return $this->postData;
    }

    /**
     * @param string $postData
     * @return VideoDto
     */
    public function setPostData(string $postData): VideoDto
    {
        try {
            $this->postData = new \DateTimeImmutable($postData);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Неверный формат даты.');
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getNumberLike(): int
    {
        return $this->numberLike;
    }

    /**
     * @param int $numberLike
     * @return VideoDto
     */
    public function setNumberLike(int $numberLike): VideoDto
    {
        $this->numberLike = $numberLike;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberDislike(): int
    {
        return $this->numberDislike;
    }

    /**
     * @param int $numberDislike
     * @return VideoDto
     */
    public function setNumberDislike(int $numberDislike): VideoDto
    {
        $this->numberDislike = $numberDislike;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberViews(): int
    {
        return $this->numberViews;
    }

    /**
     * @param int $numberViews
     * @return VideoDto
     */
    public function setNumberViews(int $numberViews): VideoDto
    {
        $this->numberViews = $numberViews;
        return $this;
    }
}
