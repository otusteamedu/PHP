<?php

namespace Bjlag\Models;

use Bjlag\BaseModel;
use Bjlag\Models\Dto\ChannelDto;
use MongoDB\BSON\ObjectId;

class Channel extends BaseModel
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
        return $this->db->find(self::TABLE, $select, $where, $limit, $offset);
    }

    /**
     * @param string $id
     * @return array
     */
    public function findById(string $id): array
    {
        $data = $this->db->find(self::TABLE, [], [self::FIELD_ID => $id], 1);
        return $data[0] ?? [];
    }

    /**
     * @param array $ids
     * @return array
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

        return $this->db->find(self::TABLE, [],  [self::FIELD_ID => ['$in' => $idsObject]]);
    }

    /**
     * @param \Bjlag\Models\Dto\ChannelDto $data
     * @return mixed
     */
    public function add(ChannelDto $data)
    {
        $addedData = [
            self::FIELD_URL => $data->getUrl(),
            self::FIELD_NAME => $data->getName(),
            self::FIELD_DESCRIPTION => $data->getDescription(),
            self::FIELD_BANNER => $data->getBanner(),
            self::FIELD_COUNTRY => $data->getCountry(),
            self::FIELD_REGISTRATION_DATA => $data->getRegistrationData(),
            self::FIELD_NUMBER_VIEWS => $data->getNumberViews(),
            self::FIELD_NUMBER_SUBSCRIBES => $data->getNumberSubscribes(),
            self::FIELD_LINKS => $data->getLinks(),
        ];

        return $this->db->add(self::TABLE, $addedData);
    }

    /**
     * @param array $where
     * @param \Bjlag\Models\Dto\ChannelDto $data
     * @return mixed
     */
    public function update(array $where, ChannelDto $data)
    {
        $updatedData = [
            self::FIELD_URL => $data->getUrl(),
            self::FIELD_NAME => $data->getName(),
            self::FIELD_DESCRIPTION => $data->getDescription(),
            self::FIELD_BANNER => $data->getBanner(),
            self::FIELD_COUNTRY => $data->getCountry(),
            self::FIELD_REGISTRATION_DATA => $data->getRegistrationData(),
            self::FIELD_NUMBER_VIEWS => $data->getNumberViews(),
            self::FIELD_NUMBER_SUBSCRIBES => $data->getNumberSubscribes(),
            self::FIELD_LINKS => $data->getLinks(),
        ];

        return $this->db->update(self::TABLE, $where, $updatedData);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function delete(array $where): int
    {
        return $this->db->delete(self::TABLE, $where);
    }
}
