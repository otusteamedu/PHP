<?php

namespace Bjlag\Repositories;

use Bjlag\App;
use Bjlag\Db\Store;
use Bjlag\Entities\ChannelEntity;
use MongoDB\BSON\ObjectId;

class ChannelRepository
{
    /** @var \Bjlag\Db\Store */
    private $db;

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
     * @param array $select
     * @param array $where
     * @param int $limit
     * @param int $offset
     *
     * @return ChannelEntity[]
     */
    public function find(array $select = [], array $where = [], int $limit = 20, int $offset = 0): array
    {
        $rows = $this->db->find(ChannelEntity::TABLE, $select, $where, $limit, $offset);
        return $this->getEntitiesSet($rows);
    }

    /**
     * @param string $id
     * @return \Bjlag\Entities\ChannelEntity|null
     */
    public function findById(string $id): ?ChannelEntity
    {
        $data = $this->db->find(ChannelEntity::TABLE, [], [ChannelEntity::FIELD_ID => $id], 1);
        return $this->createEntity(count($data) !== 0 ? reset($data) : []);
    }

    /**
     * @param array $ids
     * @return ChannelEntity[]
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

        $rows = $this->db->find(ChannelEntity::TABLE, [],  [ChannelEntity::FIELD_ID => ['$in' => $idsObject]]);

        return $this->getEntitiesSet($rows);
    }

    /**
     * @param array $rows
     * @return ChannelEntity[]
     */
    private function getEntitiesSet(array $rows): array
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
     * @return \Bjlag\Entities\ChannelEntity|null
     */
    private function createEntity(array $data): ?ChannelEntity
    {
        if (count($data) === 0) {
            return null;
        }

        return (new ChannelEntity())
            ->setId($data[ChannelEntity::FIELD_ID])
            ->setUrl($data[ChannelEntity::FIELD_URL])
            ->setName($data[ChannelEntity::FIELD_NAME])
            ->setDescription($data[ChannelEntity::FIELD_DESCRIPTION])
            ->setBanner($data[ChannelEntity::FIELD_BANNER])
            ->setCountry($data[ChannelEntity::FIELD_COUNTRY])
            ->setRegistrationData($data[ChannelEntity::FIELD_REGISTRATION_DATA])
            ->setNumberViews($data[ChannelEntity::FIELD_NUMBER_VIEWS])
            ->setNumberSubscribes($data[ChannelEntity::FIELD_NUMBER_SUBSCRIBES])
            ->setLinks($data[ChannelEntity::FIELD_LINKS]);
    }
}
