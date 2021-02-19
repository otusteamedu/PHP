<?php

namespace Models;

use Storage\ElasticSearch;
use Storage\Storage;

class ChannelMapper extends Mapper
{
    public const TABLE_NAME = 'channels';

    public static function getStats(string $channelId): array
    {
        $rawStats = Storage::getInstance()->getStorage()->calculateStats($channelId);

        $result = [
            'channelId'  => $channelId,
            'likeSum'    => $rawStats['likeSum']['value'] ?? 0,
            'dislikeSum' => $rawStats['dislikeSum']['value'] ?? 0,
            'viewSum'    => $rawStats['viewSum']['value'] ?? 0,
            'commentSum' => $rawStats['commentSum']['value'] ?? 0,
        ];

        return $result;
    }
}
