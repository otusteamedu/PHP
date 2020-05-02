<?php

namespace Bjlag\Mappers;

use Bjlag\App;
use Bjlag\Db\Store;
use Bjlag\Entities\ChannelEntity;
use Bjlag\Http\Forms\ChannelForm;
use MongoDB\BSON\ObjectId;

class ChannelMapper
{
    public const TABLE = 'channel';

    public const FIELD_ID = 'id';
    public const FIELD_URL = 'url';
    public const FIELD_NAME = 'name';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_BANNER = 'banner';
    public const FIELD_COUNTRY = 'country';
    public const FIELD_REGISTRATION_DATA = 'registration_data';
    public const FIELD_NUMBER_VIEWS = 'number_views';
    public const FIELD_NUMBER_SUBSCRIBES = 'number_subscribes';
    public const FIELD_LINKS = 'links';

    /** @var \Bjlag\Db\Store */
    protected $db;

    /**
     * @param \Bjlag\Db\Store|null $db
     */
    public function __construct(Store $db = null)
    {
        if ($db === null) {
            $this->db = App::getDb();
        } else {
            $this->db = $db;
        }
    }

    /**
     * @param \Bjlag\Http\Forms\ChannelForm $form
     * @return \Bjlag\Entities\ChannelEntity
     */
    public static function create(ChannelForm $form): ChannelEntity
    {
        return (new ChannelEntity())
            ->setUrl($form->getUrl())
            ->setName($form->getName())
            ->setDescription($form->getDescription())
            ->setBanner($form->getBanner())
            ->setCountry($form->getCountry())
            ->setRegistrationData($form->getRegistrationData())
            ->setNumberViews($form->getNumberViews())
            ->setNumberSubscribes($form->getNumberSubscribes())
            ->setLinks($form->getLinks());
    }

    /**
     * @param \Bjlag\Entities\ChannelEntity $entity
     * @return mixed
     */
    public function save(ChannelEntity $entity)
    {
        $data = [
            self::FIELD_URL => $entity->getUrl(),
            self::FIELD_NAME => $entity->getName(),
            self::FIELD_DESCRIPTION => $entity->getDescription(),
            self::FIELD_BANNER => $entity->getBanner(),
            self::FIELD_COUNTRY => $entity->getCountry(),
            self::FIELD_REGISTRATION_DATA => $entity->getRegistrationData(),
            self::FIELD_NUMBER_VIEWS => $entity->getNumberViews(),
            self::FIELD_NUMBER_SUBSCRIBES => $entity->getNumberSubscribes(),
            self::FIELD_LINKS => $entity->getLinks(),
        ];

        if ($entity->getId() === null) {
            return $this->db->add(self::TABLE, $data);
        } else {
            return $this->db->update(self::TABLE, [self::FIELD_ID => $entity->getId()], $data);
        }
    }

    /**
     * @param \Bjlag\Entities\ChannelEntity $entity
     * @return bool
     */
    public function delete(ChannelEntity $entity): bool
    {
        return (bool) $this->db->delete(self::TABLE, [
            self::FIELD_ID => $entity->getId()
        ]);
    }

    /**
     * @param array $select
     * @param array $where
     * @param int $limit
     * @param int $offset
     *
     * @return self[]
     */
    public function find(array $select = [], array $where = [], int $limit = 20, int $offset = 0): array
    {
        $rows = $this->db->find(self::TABLE, $select, $where, $limit, $offset);
        return $this->getEntitiesCollection($rows);
    }

    /**
     * @param string $id
     * @return \Bjlag\Entities\self|null
     */
    public function findById(string $id): ?ChannelEntity
    {
        $data = $this->db->find(self::TABLE, [], [self::FIELD_ID => $id], 1);
        return $this->createEntity(count($data) !== 0 ? reset($data) : []);
    }

    /**
     * @param array $ids
     * @return self[]
     */
    public function findByIds(array $ids): array
    {
        if (count($ids) === 0) {
            return [];
        }

        $idsObject = [];
        foreach ($ids as $key => $id) {
            $idsObject[] = new ObjectId($id);
        }

        $rows = $this->db->find(self::TABLE, [],  [self::FIELD_ID => ['$in' => $idsObject]]);

        return $this->getEntitiesCollection($rows);
    }

    /**
     * @param array $rows
     * @return self[]
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
     * @return \Bjlag\Mappers\ChannelMapper|null
     */
    private function createEntity(array $data): ?ChannelEntity
    {
        if (count($data) === 0) {
            return null;
        }

        return (new ChannelEntity())
            ->setId($data[self::FIELD_ID])
            ->setUrl($data[self::FIELD_URL])
            ->setName($data[self::FIELD_NAME])
            ->setDescription($data[self::FIELD_DESCRIPTION])
            ->setBanner($data[self::FIELD_BANNER])
            ->setCountry($data[self::FIELD_COUNTRY])
            ->setRegistrationData($data[self::FIELD_REGISTRATION_DATA])
            ->setNumberViews($data[self::FIELD_NUMBER_VIEWS])
            ->setNumberSubscribes($data[self::FIELD_NUMBER_SUBSCRIBES])
            ->setLinks($data[self::FIELD_LINKS]);
    }
}
