<?php

namespace Bjlag\Models;

use Bjlag\App;

class Channel
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
    public static function find(array $select = [], array $where = [], int $limit = 20, int $offset = 0): array
    {
        return App::getDb()->find(self::TABLE, $select, $where, $limit, $offset);
    }

    /**
     * @param string $id
     * @return array
     */
    public static function findById(string $id): array
    {
        $data = App::getDb()->find(self::TABLE, [],  [self::FIELD_ID => $id], 1);
        return $data[0] ?? [];
    }

    /**
     * @param array $data
     * @return mixed
     */
    public static function add(array $data)
    {
        return App::getDb()->add(self::TABLE, $data);
    }

    /**
     * @param array $where
     * @param array $data
     * @return mixed
     */
    public static function update(array $where, array $data)
    {
        return App::getDb()->update(self::TABLE, $where, $data);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public static function delete(array $where): int
    {
        return App::getDb()->delete(self::TABLE, $where);
    }
}
