<?php

namespace Bjlag\Entities;

use Bjlag\BaseModel;
use Bjlag\Http\Forms\VideoCreateForms;

class VideoEntity extends BaseModel
{
    public const TABLE = 'video';

    public const FIELD_ID = 'id';
    public const FIELD_CHANNEL_ID = 'channel_id';
    public const FIELD_URL = 'url';
    public const FIELD_NAME = 'name';
    public const FIELD_PREVIEW_IMAGE = 'preview_image';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_CATEGORY = 'category';
    public const FIELD_DURATION = 'duration';
    public const FIELD_POST_DATA = 'post_data';
    public const FIELD_NUMBER_LIKE = 'number_like';
    public const FIELD_NUMBER_DISLIKE = 'number_dislike';
    public const FIELD_NUMBER_VIEWS = 'number_views';

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
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return \Bjlag\Entities\VideoEntity
     */
    public function setId(?string $id): self
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
     * @return \Bjlag\Entities\VideoEntity
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
     * @return \Bjlag\Entities\VideoEntity
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
     * @return \Bjlag\Entities\VideoEntity
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
     * @return \Bjlag\Entities\VideoEntity
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
     * @return \Bjlag\Entities\VideoEntity
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
     * @return \Bjlag\Entities\VideoEntity
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
     * @return \Bjlag\Entities\VideoEntity
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
     * @param array|string|object $postData
     * @return \Bjlag\Entities\VideoEntity
     */
    public function setPostData($postData): self
    {
        try {
            if (is_string($postData)) {
                $this->postData = new \DateTimeImmutable($postData);
            } elseif (is_array($postData)) {
                $this->postData = new \DateTimeImmutable($postData['date']);
            } elseif(is_object($postData)) {
                $this->postData = new \DateTimeImmutable($postData->{'date'});
            } else {
                throw new \InvalidArgumentException('Неверный формат даты.');
            }
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
     * @return \Bjlag\Entities\VideoEntity
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
     * @return \Bjlag\Entities\VideoEntity
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
     * @return \Bjlag\Entities\VideoEntity
     */
    public function setNumberViews(int $numberViews): self
    {
        $this->numberViews = $numberViews;
        return $this;
    }

    /**
     * @param \Bjlag\Http\Forms\VideoCreateForms $form
     * @return static
     */
    public static function create(VideoCreateForms $form): self
    {
        return (new VideoEntity())
            ->setChannelId($form->getChannelId())
            ->setUrl($form->getUrl())
            ->setName($form->getName())
            ->setPreviewImage($form->getPreviewImage())
            ->setDescription($form->getDescription())
            ->setCategory($form->getCategory())
            ->setDuration($form->getDuration())
            ->setPostData($form->getPostData())
            ->setNumberLike($form->getNumberLike())
            ->setNumberDislike($form->getNumberDislike())
            ->setNumberViews($form->getNumberViews());
    }

    /**
     * @return mixed
     */
    public function save()
    {
        $data = [
            self::FIELD_CHANNEL_ID => $this->getChannelId(),
            self::FIELD_URL => $this->getUrl(),
            self::FIELD_NAME => $this->getName(),
            self::FIELD_PREVIEW_IMAGE => $this->getPreviewImage(),
            self::FIELD_DESCRIPTION => $this->getDescription(),
            self::FIELD_CATEGORY => $this->getCategory(),
            self::FIELD_DURATION => $this->getDuration(),
            self::FIELD_POST_DATA => $this->getPostData(),
            self::FIELD_NUMBER_LIKE => $this->getNumberLike(),
            self::FIELD_NUMBER_DISLIKE => $this->getNumberDislike(),
            self::FIELD_NUMBER_VIEWS => $this->getNumberViews(),
        ];

        if ($this->getId() === null) {
            return $this->db->add(self::TABLE, $data);
        } else {
            return $this->db->update(self::TABLE, [self::FIELD_ID => $this->getId()], $data);
        }
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return $this->db->delete(self::TABLE, [
            self::FIELD_ID => $this->getId()
        ]);
    }
}
