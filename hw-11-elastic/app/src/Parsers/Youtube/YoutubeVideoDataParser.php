<?php

namespace Parsers\Youtube;

use Exceptions\DataParserException;
use Models\VideoDTO;

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

    public function parseVideoData (string $json): ?VideoDTO
    {
        $rawData = json_decode($json, true);

        try {
            $dto = $this->makeDTO($rawData);
        } catch (DataParserException $e) {
            echo 'Error in parsing data: ' . $e->getMessage() . PHP_EOL;
            return null;
        }

        return $dto;
    }

    private function makeDTO ($rawData): VideoDTO
    {
        $id = $rawData['items'][0]['id'] ?? '';

        if (empty($id)) {
            throw new DataParserException('Video id is not parsed');
        }

        $title = $rawData['items'][0]['snippet']['title'] ?? '';

        if (empty($title)) {
            throw new DataParserException('Video title is not parsed');
        }

        $channelId = $rawData['items'][0]['snippet']['channelId'] ?? '';

        if (empty($channelId)) {
            throw new DataParserException('Video channelId is not parsed');
        }

        return new VideoDTO(
            $id,
            $title,
            $channelId,
            $rawData['items'][0]['statistics']['viewCount'] ?? 0,
            $rawData['items'][0]['statistics']['likeCount'] ?? 0,
            $rawData['items'][0]['statistics']['dislikeCount'] ?? 0,
            $rawData['items'][0]['statistics']['commentCount'] ?? 0,
        );
    }
}