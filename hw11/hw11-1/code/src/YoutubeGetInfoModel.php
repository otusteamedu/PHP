<?php


namespace YoutubeApp;


use GuzzleHttp\Client;

class YoutubeGetInfoModel
{
    private \GuzzleHttp\Client $httpClient;
    private const API_KEY = "AIzaSyBlKT2FPT1v5VTYFY_pLG984bLh31LR-N4";
    private const VIDEO_MAX_RESULTS = 5;

    public function __construct()
    {
        $this->httpClient = new Client();

    }

    public function getChannelInfoByName(string $channelName): object
    {
        $queryParams = [
            'key' => self::API_KEY,
            'part' => 'snippet',
            'forUsername' => $channelName
        ];

        $result = $this->httpClient->request('GET', 'https://www.googleapis.com/youtube/v3/channels', ['query' => $queryParams]);
        return json_decode($result->getBody());
    }

    public function getVideosInfoByChannelId(string $channelId): object
    {
        $queryParams = [
            'key' => self::API_KEY,
            'part' => 'snippet',
            'maxResults' => self::VIDEO_MAX_RESULTS,
            'channelId' => $channelId
        ];

        $result = $this->httpClient->request('GET', 'https://www.googleapis.com/youtube/v3/search', ['query' => $queryParams]);
        return json_decode($result->getBody());
    }

    public function getVideosStatisticsById(string $videoId): object
    {
        $queryParams = [
            'key' => self::API_KEY,
            'part' => 'statistics',
            'id' => $videoId
        ];

        $result = $this->httpClient->request('GET', 'https://www.googleapis.com/youtube/v3/videos', ['query' => $queryParams]);
        return json_decode($result->getBody());
    }
}