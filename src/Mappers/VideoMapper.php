<?php

namespace Bjlag\Mappers;

use Bjlag\BaseMapper;
use Bjlag\Entities\VideoEntity;
use Bjlag\Http\Forms\VideoForm;

class VideoMapper extends BaseMapper
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

    private const LINKS = [
        ChannelMapper::class => [
            self::LINK_FIELD => self::FIELD_CHANNEL_ID,
            self::LINK_SETTER => 'setChannel',
        ],
    ];

    /** @var array */
    private $with = [];

    /** @var \Bjlag\BaseMapper[] */
    private $mappersMap = [];

    /**
     * @param \Bjlag\Http\Forms\VideoForm $form
     * @return \Bjlag\Entities\VideoEntity
     */
    public static function create(VideoForm $form): VideoEntity
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
     * @param \Bjlag\Entities\VideoEntity $entity
     * @return mixed
     */
    public function save(VideoEntity $entity)
    {
        $data = [
            self::FIELD_CHANNEL_ID => $entity->getChannelId(),
            self::FIELD_URL => $entity->getUrl(),
            self::FIELD_NAME => $entity->getName(),
            self::FIELD_PREVIEW_IMAGE => $entity->getPreviewImage(),
            self::FIELD_DESCRIPTION => $entity->getDescription(),
            self::FIELD_CATEGORY => $entity->getCategory(),
            self::FIELD_DURATION => $entity->getDuration(),
            self::FIELD_POST_DATA => $entity->getPostData(),
            self::FIELD_NUMBER_LIKE => $entity->getNumberLike(),
            self::FIELD_NUMBER_DISLIKE => $entity->getNumberDislike(),
            self::FIELD_NUMBER_VIEWS => $entity->getNumberViews(),
        ];

        if ($entity->getId() === null) {
            return $this->db->add(self::TABLE, $data);
        } else {
            return $this->db->update(self::TABLE, [self::FIELD_ID => $entity->getId()], $data);
        }
    }

    /**
     * @param \Bjlag\Entities\VideoEntity $entity
     * @return bool
     */
    public function delete(VideoEntity $entity): bool
    {
        return $this->db->delete(self::TABLE, [
            self::FIELD_ID => $entity->getId()
        ]);
    }

    /**
     * @param array $select
     * @param array $where
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function find(array $select = [], array $where = [], int $limit = 20, int $offset = 0): array
    {
        $rows = $this->db->find(self::TABLE, $select, $where, $limit, $offset);
        return $this->getEntitiesCollection($rows);
    }

    /**
     * @param string $id
     * @return \Bjlag\Entities\VideoEntity|null
     */
    public function findById(string $id): ?VideoEntity
    {
        $data = $this->db->find(self::TABLE, [], [self::FIELD_ID => $id], 1);
        return $this->createEntity(count($data) !== 0 ? reset($data) : []);
    }

    /**
     * @param string $channelId
     * @return \Bjlag\Entities\VideoEntity|null
     */
    public function findByChannelId(string $channelId): ?VideoEntity
    {
        $data = $this->db->find(self::TABLE, [], [self::FIELD_CHANNEL_ID => $channelId]);
        return $this->createEntity(count($data) !== 0 ? reset($data) : []);
    }

    /**
     * @param string $link
     * @return $this
     */
    public function with(string $link): self
    {
        if (!isset(self::LINKS[$link])) {
            throw new \DomainException("Не описана связь {$link}");
        }

        $this->with[] = $link;
        return $this;
    }

    /**
     * @param array $rows
     * @return VideoEntity[]
     */
    private function getEntitiesCollection(array $rows): array
    {
        if (count($rows) === 0) {
            return [];
        }

        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->createEntity($row);
        }

        return $result;
    }

    /**
     * @param array $data
     * @return \Bjlag\Entities\VideoEntity|null
     */
    private function createEntity(array $data): ?VideoEntity
    {
        if (count($data) === 0) {
            return null;
        }

        $videoEntity = (new VideoEntity())
            ->setId($data[self::FIELD_ID])
            ->setChannelId($data[self::FIELD_CHANNEL_ID])
            ->setUrl($data[self::FIELD_URL])
            ->setName($data[self::FIELD_NAME])
            ->setPreviewImage($data[self::FIELD_PREVIEW_IMAGE])
            ->setDescription($data[self::FIELD_DESCRIPTION])
            ->setCategory($data[self::FIELD_CATEGORY])
            ->setDuration($data[self::FIELD_DURATION])
            ->setPostData($data[self::FIELD_POST_DATA])
            ->setNumberLike($data[self::FIELD_NUMBER_LIKE])
            ->setNumberDislike($data[self::FIELD_NUMBER_DISLIKE])
            ->setNumberViews($data[self::FIELD_NUMBER_VIEWS]);

        foreach ($this->with as $link) {
            if (!isset($this->mappersMap[$link])) {
                /** @var \Bjlag\BaseMapper $mapper */
                $mapper = new $link();
                if (!($mapper instanceof BaseMapper)) {
                    throw new \DomainException("Mapper {$link} не корректный.");
                }

                $this->mappersMap[$link] = $mapper;
            }

            $mapper = $this->mappersMap[$link];

            $linkField = self::LINKS[$link]['link_field'];
            $setter = self::LINKS[$link]['setter'];
            $linkEntityId = $data[$linkField];

            $entity = $mapper->findById($linkEntityId);
            if ($entity !== null) {
                if (!method_exists($videoEntity, $setter)) {
                    throw new \DomainException("В {$link} не определен метод {$setter}.");
                }

                $videoEntity->$setter($entity);
            }
        }

        return $videoEntity;
    }
}
