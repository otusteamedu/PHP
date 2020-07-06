<?php

namespace App\Services;

use GuzzleHttp\Client;

class YouTubeInfoFetcher
{
    private Client $client;
    private const API_KEY = "Ваш Api ключ";
    private const MAX_VIDEO_RESULT = 10;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getChannelInfoByChannelName(string $channel)
    {
        $queryParameters = [
            'key' => self::API_KEY,
            'part' => 'snippet',
            'forUsername' => $channel,
        ];
        $result = $this->client->request(
            'GET',
            'https://www.googleapis.com/youtube/v3/channels',
            ['query' => $queryParameters]
        );
        return json_decode($result->getBody());
    }

    public function getChannelVideoIds($channelId)
    {
        $queryParameters = [
            'key' => self::API_KEY,
            'part' => 'snippet',
            'maxResults' => self::MAX_VIDEO_RESULT,
            'channelId' => $channelId
        ];
        $result = $this->client->request(
            'GET',
            'https://www.googleapis.com/youtube/v3/search',
            ['query' => $queryParameters]
        );
        $result_videos = json_decode($result->getBody());

        $videoIds = [];

        foreach ($result_videos->items as $video) {
            if (isset($video->id->videoId)) {
                $videoIds[] = $video->id->videoId;
            }
        }
        return $videoIds;
    }

    public function getVideosStatistic($videoId)
    {
        $queryParameters = [
            'key' => self::API_KEY,
            'part' => 'snippet,contentDetails,statistics,status',
            'id' => $videoId
        ];
        $result = $this->client->request(
            'GET',
            'https://www.googleapis.com/youtube/v3/videos',
            ['query' => $queryParameters]
        );
        return json_decode($result->getBody());
    }
}