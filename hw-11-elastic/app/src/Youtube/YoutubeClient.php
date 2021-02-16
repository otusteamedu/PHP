<?php

namespace Youtube;

use Config\Config;
use Exception;

class YoutubeClient
{
    private const YOUTUBE_API_KEY_CONFIG_KEY = 'youtube_api_key';
    private const YOUTUBE_API_URL            = 'https://youtube.googleapis.com/youtube/v3';

    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = (new Config())->getItem(self::YOUTUBE_API_KEY_CONFIG_KEY);
    }

    public function getChannelData (string $channelId): ?array
    {
        $params = [
            'part'      => 'snippet,contentDetails,statistics',
            'order'     => 'date',
            'id'        => $channelId,
            'key'       => $this->apiKey,
        ];

        $url = $this->generateURL('channels', $params);
        echo $url . PHP_EOL;
        return json_decode($this->sendRequest($url), true);
    }

    private function generateURL (string $cmd, array $params): string
    {
        return self::YOUTUBE_API_URL . "/{$cmd}?" . http_build_query($params);
    }

    private function sendRequest(string $url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        if (empty($response)) {
            throw new Exception('Empty response');
        }
        curl_close($ch);
        return $response;
    }
}