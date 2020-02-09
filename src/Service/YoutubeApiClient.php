<?php declare(strict_types=1);

namespace Service;

use GuzzleHttp\Client;
use Service\Config\YoutubeConfigProviderInterface;

class YoutubeApiClient
{
    private Client $client;
    private string $apiKey;
    private YoutubeConfigProviderInterface $configProvider;

    public function __construct(YoutubeConfigProviderInterface $configProvider)
    {
        $this->configProvider = $configProvider;
        $this->apiKey = $this->configProvider->getApiKey();
        $this->client = new Client([
            'base_uri' => $this->configProvider->getApiBaseUrl()
        ]);
    }

    public function getChannelsList(string $query, int $maxResults = 10): array
    {
        $response = $this->client->request('get', $this->configProvider->getSearchApiPath(), [
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
        $response = $this->client->request('get', $this->configProvider->getSearchApiPath(), [
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
        $response = $this->client->request('get', $this->configProvider->getVideosApiPath(), [
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
