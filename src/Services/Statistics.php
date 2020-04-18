<?php

namespace Bjlag\Services;

use Bjlag\App;
use Bjlag\Models\Video;

class Statistics
{
    /**
     * Суммарное кол-во лайков и дизлайков для канала по всем его видео.
     *
     * @param string $channelId
     * @return \Bjlag\Services\LikeStatistics
     */
    public static function calcTotalLikesAndDislikesByChannelId(string $channelId): LikeStatistics
    {
        $result = self::aggregateLikes($channelId);

        return (new LikeStatistics())
            ->setLikesTotal($result[0]['likes_total'] ?? 0)
            ->setDislikesTotal($result[0]['dislikes_total'] ?? 0);
    }

    /**
     * Топ N каналов с лучшим соотношением кол-во лайков/кол-во дизлайков
     *
     * @return \Bjlag\Services\TopChannelStatistics
     */
    public static function getTop5Channels()
    {
        $result = self::aggregateLikes(null, 5);

        return (new TopChannelStatistics())->setChannelIds($result);
    }

    /**
     * @param string|null $filterByChannel
     * @param int|null $limit
     * @return array
     */
    private static function aggregateLikes(?string $filterByChannel = null, ?int $limit = null): array
    {
        /** @var \Bjlag\Db\Adapters\MongoDb $db */
        $db = App::getDb();
        $collection = $db->getCollection(Video::TABLE);

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
