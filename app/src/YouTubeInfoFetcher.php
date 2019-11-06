<?php

namespace App;

use GuzzleHttp\Client;

class YouTubeInfoFetcher
{
    private $httpClient;
    private const API_KEY = "AIzaSyBRR-fOzjnPxKCaO7iwxkkWsXm0nBYMVQE";
    private const VIDEO_MAX_RESULTS = 5;

    public function __construct()
    {
        $this->httpClient = new Client();

    }

    /**
     * @param string $channelName
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getChannelInfoByName (string $channelName)
    {
        $queryParams = [
            'key' => self::API_KEY,
            'part' => 'snippet',
            'forUsername' => $channelName
        ];

        $result = $this->httpClient->request('GET', 'https://www.googleapis.com/youtube/v3/channels', ['query' => $queryParams]);
        return json_decode($result->getBody());
    }

    /**
     * @param string $channelId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVideosInfoByChannelId(string $channelId)
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

    /**
     * @param string $videoId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVideosStatisticsById(string $videoId)
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