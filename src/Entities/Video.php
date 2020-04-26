<?php

namespace Bjlag\Entities;

use Bjlag\BaseModel;
use Bjlag\Entities\Dto\VideoDto;

class Video extends BaseModel
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
    public function find(array $select = [], array $where = [], int $limit = 20, int $offset = 0): array
    {
        return $this->db->find(self::TABLE, $select, $where, $limit, $offset);
    }

    /**
     * @param string $channelId
     * @return array
     */
    public function findByChannelId(string $channelId): array
    {
        return $this->db->find(self::TABLE, [], [self::FIELD_CHANNEL_ID => $channelId]);
    }

    /**
     * @param \Bjlag\Entities\Dto\VideoDto $data
     * @return mixed
     */
    public function add(VideoDto $data)
    {
        $addedData = [
            self::FIELD_CHANNEL_ID => $data->getChannelId(),
            self::FIELD_URL => $data->getUrl(),
            self::FIELD_NAME => $data->getName(),
            self::FIELD_PREVIEW_IMAGE => $data->getPreviewImage(),
            self::FIELD_DESCRIPTION => $data->getDescription(),
            self::FIELD_CATEGORY => $data->getCategory(),
            self::FIELD_DURATION => $data->getDuration(),
            self::FIELD_POST_DATA => $data->getPostData(),
            self::FIELD_NUMBER_LIKE => $data->getNumberLike(),
            self::FIELD_NUMBER_DISLIKE => $data->getNumberDislike(),
            self::FIELD_NUMBER_VIEWS => $data->getNumberViews(),
        ];

        return $this->db->add(self::TABLE, $addedData);
    }

    /**
     * @param array $where
     * @param \Bjlag\Entities\Dto\VideoDto $data
     * @return mixed
     */
    public function update(array $where, VideoDto $data)
    {
        $updatedData = [
            self::FIELD_CHANNEL_ID => $data->getChannelId(),
            self::FIELD_URL => $data->getUrl(),
            self::FIELD_NAME => $data->getName(),
            self::FIELD_PREVIEW_IMAGE => $data->getPreviewImage(),
            self::FIELD_DESCRIPTION => $data->getDescription(),
            self::FIELD_CATEGORY => $data->getCategory(),
            self::FIELD_DURATION => $data->getDuration(),
            self::FIELD_POST_DATA => $data->getPostData(),
            self::FIELD_NUMBER_LIKE => $data->getNumberLike(),
            self::FIELD_NUMBER_DISLIKE => $data->getNumberDislike(),
            self::FIELD_NUMBER_VIEWS => $data->getNumberViews(),
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
