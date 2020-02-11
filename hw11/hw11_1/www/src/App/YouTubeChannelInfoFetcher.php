<?php

namespace App;

use GuzzleHttp\Client;

class YouTubeChannelInfoFetcher
{
    private $client;
    private const API_KEY = "your_api_key";
    private const MAX_VIDEO_RESULTS = 8;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * получение информации о канале
     *
     * @param string $channel
     * @return mixed
     */
    public function getChannelInfoByLogin(string $channel)
    {
        $queryParameters = [
            'key' => self::API_KEY,
            'part' => 'snippet',
            'forUsername' => $channel
        ];
        $result = $this->client->request('GET', 'https://www.googleapis.com/youtube/v3/channels', ['query' => $queryParameters]);
        return json_decode($result->getBody());
    }

    /**
     * Получение видео канала
     *
     * @param $channelId
     * @return mixed
     */
    public function getChannelVideoIds($channelId) {
        $queryParameters = [
            'key' => self::API_KEY,
            'part' => 'snippet',
            'maxResults' => self::MAX_VIDEO_RESULTS,
            'channelId' => $channelId
        ];
        $result = $this->client->request('GET', 'https://www.googleapis.com/youtube/v3/search', ['query' => $queryParameters]);
        $result_videos = json_decode($result->getBody());

        $videoIds = [];

        foreach ($result_videos->items as $video) {
            if (isset($video->id->videoId)) {
                $videoIds[] = $video->id->videoId;
            }
        }
        return $videoIds;
    }

    /**
     * Получение статистики видео
     *
     * @param $videoId
     * @return mixed
     */
    public function getVideosStatistic($videoId) {
        $queryParameters = [
            'key' => self::API_KEY,
            'part' => 'snippet,contentDetails,statistics,status',
            'id' => $videoId
        ];
        $result = $this->client->request('GET', 'https://www.googleapis.com/youtube/v3/videos', ['query' => $queryParameters]);
        return json_decode($result->getBody());
    }
}