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

    // - Топ N каналов с лучшим соотношением кол-во лайков/кол-во дизлайков
    public function getTopChannels()
    {

    }

    /**
     * @param string|null $filterByChannel
     * @return array
     */
    private static function aggregateLikes(?string $filterByChannel = null): array
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

        /** @var \MongoDB\Driver\Cursor $cursor */
        $cursor = $collection->aggregate($pipeline);

        return $cursor->toArray();
    }
}
