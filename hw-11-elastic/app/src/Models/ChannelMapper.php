<?php

namespace Models;

use Storage\Storage;

class ChannelMapper
{
    public const TABLE_NAME = 'channels';

    public static function getAll (): array
    {
        $result = [];

        $hits = Storage::getInstance()->getStorage()->getAll(self::TABLE_NAME);

        foreach ($hits as $channel) {
            $result[] = new ChannelDTO(
                $channel['id'],
                $channel['title'] ?? '',
                $channel['description'] ?? '',
                $channel['thumbnail'] ?? ''
            );
        }

        return $result;
    }

    public static function getStats(string $channelId): array
    {
        $result = Storage::getInstance()->getStorage()->calculateStats($channelId);

        $result['likesPlusDislikesSum'] = $result['likeSum'] + $result['dislikeSum'];

        $result['likeWeight'] = self::getLikeWeight($result['likeSum'], $result['dislikeSum']);

        return $result;
    }

    private static function getLikeWeight($likeSum, $dislikeSum): float
    {
        $result = 0;

        if ($dislikeSum > 0) {
            $result = round($likeSum / $dislikeSum, 2);
        }

        return $result;
    }
}
