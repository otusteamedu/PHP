<?php declare(strict_types=1);

namespace Service;

use GuzzleHttp\Client;

class YoutubeApiClient
{
    private Client $client;
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = 'AIzaSyAAnt7kjNqCouYAPeW4R7USUReIpgoO66U';
        $this->client = new Client([
            'base_uri' => 'https://www.googleapis.com'
        ]);
    }

    public function getChannelsList(string $query, int $maxResults = 10): array
    {
        $response = $this->client->request('get', '/youtube/v3/search', [
            'query' => [
                'key' => $this->apiKey,
                'part' => 'snippet',
                'maxResults' => $maxResults,
                'q' => $query,
                'regionCode' => 'ru',
                'type' => 'channel',
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getVideosList(string $channelId, int $maxResults = 10): array
    {
        $response = $this->client->request('get', '/youtube/v3/search', [
            'query' => [
                'key' => $this->apiKey,
                'part' => 'snippet',
                'maxResults' => $maxResults,
                'type' => 'video',
                'channelId' => $channelId,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getVideoStatistics(string $videoId): ?array
    {
        $response = $this->client->request('get', '/youtube/v3/videos', [
            'query' => [
                'key' => $this->apiKey,
                'part' => 'statistics',
                'id' => $videoId,
            ]
        ]);
        $items = json_decode($response->getBody()->getContents(), true)['items'];

        return $items[0] ?? null;
    }
}
