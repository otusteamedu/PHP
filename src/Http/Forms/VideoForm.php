<?php

namespace Bjlag\Http\Forms;

use Bjlag\BaseForm;
use Bjlag\Mappers\VideoMapper;

class VideoForm extends BaseForm
{
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
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
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
     * @return VideoForm
     */
    public function setChannelId(string $channelId): VideoForm
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
     * @return VideoForm
     */
    public function setUrl(string $url): VideoForm
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
     * @return VideoForm
     */
    public function setName(string $name): VideoForm
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
     * @return VideoForm
     */
    public function setPreviewImage(string $previewImage): VideoForm
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
     * @return VideoForm
     */
    public function setDescription(string $description): VideoForm
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
     * @return VideoForm
     */
    public function setCategory(string $category): VideoForm
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
     * @return VideoForm
     */
    public function setDuration(string $duration): VideoForm
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
     * @return VideoForm
     */
    public function setPostData(string $postData): VideoForm
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
     * @return VideoForm
     */
    public function setNumberLike(int $numberLike): VideoForm
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
     * @return VideoForm
     */
    public function setNumberDislike(int $numberDislike): VideoForm
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
     * @return VideoForm
     */
    public function setNumberViews(int $numberViews): VideoForm
    {
        $this->numberViews = $numberViews;
        return $this;
    }

    /**
     * @return array
     */
    protected function getFields(): array
    {
        return [
            VideoMapper::FIELD_CHANNEL_ID,
            VideoMapper::FIELD_URL,
            VideoMapper::FIELD_NAME,
            VideoMapper::FIELD_PREVIEW_IMAGE,
            VideoMapper::FIELD_DESCRIPTION,
            VideoMapper::FIELD_CATEGORY,
            VideoMapper::FIELD_DURATION,
            VideoMapper::FIELD_POST_DATA,
            VideoMapper::FIELD_NUMBER_LIKE,
            VideoMapper::FIELD_NUMBER_DISLIKE,
            VideoMapper::FIELD_NUMBER_VIEWS,
        ];
    }
}
