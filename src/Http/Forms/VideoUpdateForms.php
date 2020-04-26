<?php

namespace Bjlag\Http\Forms;

use Bjlag\Entities\VideoEntity;
use Bjlag\Forms;
use League\Route\Http\Exception\UnprocessableEntityException;
use Psr\Http\Message\ServerRequestInterface;

class VideoUpdateForms implements Forms
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
        $this->body = $request->getParsedBody()['data'];
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
     * @return \Bjlag\Http\Forms\VideoUpdateForms
     */
    public function setId(string $id)
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
     * @return \Bjlag\Http\Forms\VideoUpdateForms
     */
    public function setChannelId(string $channelId): self
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
     * @return \Bjlag\Http\Forms\VideoUpdateForms
     */
    public function setUrl(string $url): self
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
     * @return \Bjlag\Http\Forms\VideoUpdateForms
     */
    public function setName(string $name): self
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
     * @return \Bjlag\Http\Forms\VideoUpdateForms
     */
    public function setPreviewImage(string $previewImage): self
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
     * @return \Bjlag\Http\Forms\VideoUpdateForms
     */
    public function setDescription(string $description): self
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
     * @return \Bjlag\Http\Forms\VideoUpdateForms
     */
    public function setCategory(string $category): self
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
     * @return \Bjlag\Http\Forms\VideoUpdateForms
     */
    public function setDuration(string $duration): self
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
     * @return \Bjlag\Http\Forms\VideoUpdateForms
     */
    public function setPostData(string $postData): self
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
     * @return \Bjlag\Http\Forms\VideoUpdateForms
     */
    public function setNumberLike(int $numberLike): self
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
     * @return \Bjlag\Http\Forms\VideoUpdateForms
     */
    public function setNumberDislike(int $numberDislike): self
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
     * @return \Bjlag\Http\Forms\VideoUpdateForms
     */
    public function setNumberViews(int $numberViews): self
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
