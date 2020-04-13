<?php

namespace Bjlag\Models;

use Bjlag\App;

class Channel
{
    private const TABLE = 'channel';

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
}
