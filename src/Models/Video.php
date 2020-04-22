<?php

namespace Bjlag\Models;

use Bjlag\App;
use Bjlag\Models\Dto\VideoDto;

class Video
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
     * @param string $channelId
     * @return array
     */
    public static function findByChannelId(string $channelId): array
    {
        return App::getDb()->find(self::TABLE, [], [self::FIELD_CHANNEL_ID => $channelId]);
    }

    /**
     * @param \Bjlag\Models\Dto\VideoDto $data
     * @return mixed
     */
    public static function add(VideoDto $data)
    {
        return App::getDb()->add(self::TABLE, $data->toArray());
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
