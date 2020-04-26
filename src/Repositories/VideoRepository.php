<?php

namespace Bjlag\Repositories;

use Bjlag\App;
use Bjlag\Db\Store;
use Bjlag\Entities\VideoEntity;

class VideoRepository
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
     * @return array
     */
    public function find(array $select = [], array $where = [], int $limit = 20, int $offset = 0): array
    {
        $rows = $this->db->find(VideoEntity::TABLE, $select, $where, $limit, $offset);
        return $this->getEntitiesSet($rows);
    }

    /**
     * @param string $id
     * @return \Bjlag\Entities\VideoEntity|null
     */
    public function findById(string $id): ?VideoEntity
    {
        $data = $this->db->find(VideoEntity::TABLE, [], [VideoEntity::FIELD_ID => $id], 1);
        return $this->createEntity(count($data) !== 0 ? reset($data) : []);
    }

    /**
     * @param string $channelId
     * @return \Bjlag\Entities\VideoEntity|null
     */
    public function findByChannelId(string $channelId): ?VideoEntity
    {
        $data = $this->db->find(VideoEntity::TABLE, [], [VideoEntity::FIELD_CHANNEL_ID => $channelId]);
        return $this->createEntity(count($data) !== 0 ? reset($data) : []);
    }

    /**
     * @param array $rows
     * @return VideoEntity[]
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
     * @return \Bjlag\Entities\VideoEntity|null
     */
    private function createEntity(array $data)
    {
        if (count($data) === 0) {
            return null;
        }

        return (new VideoEntity())
            ->setId($data[VideoEntity::FIELD_ID])
            ->setChannelId($data[VideoEntity::FIELD_CHANNEL_ID])
            ->setUrl($data[VideoEntity::FIELD_URL])
            ->setName($data[VideoEntity::FIELD_NAME])
            ->setPreviewImage($data[VideoEntity::FIELD_PREVIEW_IMAGE])
            ->setDescription($data[VideoEntity::FIELD_DESCRIPTION])
            ->setCategory($data[VideoEntity::FIELD_CATEGORY])
            ->setDuration($data[VideoEntity::FIELD_DURATION])
            ->setPostData($data[VideoEntity::FIELD_POST_DATA])
            ->setNumberLike($data[VideoEntity::FIELD_NUMBER_LIKE])
            ->setNumberDislike($data[VideoEntity::FIELD_NUMBER_DISLIKE])
            ->setNumberViews($data[VideoEntity::FIELD_NUMBER_VIEWS]);
    }
}
