<?php

namespace Bjlag\Models;

use Bjlag\App;

class Video
{
    private const TABLE = 'video';

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
