<?php

namespace Parsers\Youtube;

use Exceptions\DataParserException;

class YoutubeVideoDataParser
{
    public function parseVideosIdList(string $json): array
    {
        $list = [];

        $rawData = json_decode($json, true);

        if (!isset($rawData['items'])) {
            throw new DataParserException('Video list is not parsed');
        }

        foreach ($rawData['items'] as $video) {
            if (isset($video['id']['videoId'])) {
                $list[] = $video['id']['videoId'];
            }
        }

        return $list;
    }
}