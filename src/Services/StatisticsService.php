<?php

namespace Bjlag\Services;

use Bjlag\App;
use Bjlag\Db\Store;
use Bjlag\Entities\Video;

class StatisticsService
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
     * Суммарное кол-во лайков и дизлайков для канала по всем его видео.
     *
     * @param string $channelId
     * @return \Bjlag\Services\LikeStatistics
     */
    public function calcTotalLikesAndDislikesByChannelId(string $channelId): LikeStatistics
    {
        $result = $this->aggregateLikes($channelId);

        return (new LikeStatistics())
            ->setLikesTotal($result[0]['likes_total'] ?? 0)
            ->setDislikesTotal($result[0]['dislikes_total'] ?? 0);
    }

    /**
     * Топ N каналов с лучшим соотношением кол-во лайков/кол-во дизлайков
     *
     * @return \Bjlag\Services\TopChannelStatistics
     */
    public function getTop5Channels()
    {
        $result = $this->aggregateLikes(null, 5);

        return (new TopChannelStatistics())->setChannelIds($result);
    }

    /**
     * @param string|null $filterByChannel
     * @param int|null $limit
     * @return array
     */
    private function aggregateLikes(?string $filterByChannel = null, ?int $limit = null): array
    {
        $collection = $this->db->getCollection(Video::TABLE);

        $pipeline = [];

        if ($filterByChannel !== null) {
            $pipeline[]['$match'] = [Video::FIELD_CHANNEL_ID => $filterByChannel];
        }

        $pipeline[]['$group'] = [
            '_id' => [Video::FIELD_CHANNEL_ID => '$' . Video::FIELD_CHANNEL_ID],
            'likes_total' => ['$sum' => '$' . Video::FIELD_NUMBER_LIKE],
            'dislikes_total' => ['$sum' => '$' . Video::FIELD_NUMBER_DISLIKE],
        ];

        $pipeline[]['$addFields'] = [
            'ratio' => ['$divide' => ['$likes_total', '$dislikes_total']],
        ];

        $pipeline[]['$sort'] = [
            'ration' => -1
        ];

        if ($limit !== null) {
            $pipeline[]['$limit'] = $limit;
        }

        /** @var \MongoDB\Driver\Cursor $cursor */
        $cursor = $collection->aggregate($pipeline);

        return $cursor->toArray();
    }
}
