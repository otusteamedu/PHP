<?php

namespace Bjlag\Http\Forms;

use Bjlag\Entities\VideoEntity;
use Bjlag\Forms;
use League\Route\Http\Exception\UnprocessableEntityException;
use Psr\Http\Message\ServerRequestInterface;

class VideoCreateForms implements Forms
{
    private const FIELDS = [
        VideoEntity::FIELD_CHANNEL_ID,
        VideoEntity::FIELD_URL,
        VideoEntity::FIELD_NAME,
        VideoEntity::FIELD_PREVIEW_IMAGE,
        VideoEntity::FIELD_DESCRIPTION,
        VideoEntity::FIELD_CATEGORY,
        VideoEntity::FIELD_DURATION,
        VideoEntity::FIELD_POST_DATA,
        VideoEntity::FIELD_NUMBER_LIKE,
        VideoEntity::FIELD_NUMBER_DISLIKE,
        VideoEntity::FIELD_NUMBER_VIEWS,
    ];

    /** @var \Psr\Http\Message\ServerRequestInterface */
    private $request;

    /** @var array */
    private $body;

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
     * @param \Psr\Http\Message\ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
        $this->body = $request->getParsedBody();
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
     * @return VideoCreateForms
     */
    public function setId(?string $id): VideoCreateForms
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
     * @return VideoCreateForms
     */
    public function setChannelId(string $channelId): VideoCreateForms
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
     * @return VideoCreateForms
     */
    public function setUrl(string $url): VideoCreateForms
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
     * @return VideoCreateForms
     */
    public function setName(string $name): VideoCreateForms
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
     * @return VideoCreateForms
     */
    public function setPreviewImage(string $previewImage): VideoCreateForms
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
     * @return VideoCreateForms
     */
    public function setDescription(string $description): VideoCreateForms
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
     * @return VideoCreateForms
     */
    public function setCategory(string $category): VideoCreateForms
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
     * @return VideoCreateForms
     */
    public function setDuration(string $duration): VideoCreateForms
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
     * @return VideoCreateForms
     */
    public function setPostData(string $postData): VideoCreateForms
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
     * @return VideoCreateForms
     */
    public function setNumberLike(int $numberLike): VideoCreateForms
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
     * @return VideoCreateForms
     */
    public function setNumberDislike(int $numberDislike): VideoCreateForms
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
     * @return VideoCreateForms
     */
    public function setNumberViews(int $numberViews): VideoCreateForms
    {
        $this->numberViews = $numberViews;
        return $this;
    }

    /**
     * @return $this
     * @throws \League\Route\Http\Exception\UnprocessableEntityException
     */
    public function fillAndValidate(): self
    {
        foreach (self::FIELDS as $field) {
            if (!isset($this->body[$field])) {
                throw new UnprocessableEntityException("Поле '{$field}' обязательно для заполнения.");
            }

            $setterName = strtr($field, ['_' => ' ']);
            $setterName = ucwords($setterName);
            $setterName = 'set' . strtr($setterName, [' ' => '']);

            $this->{$setterName}($this->body[$field]);
        }

        return $this;
    }
}
