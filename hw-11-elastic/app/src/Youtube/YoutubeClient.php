<?php

namespace Youtube;

use Config\Config;
use Models\ChannelDTO;
use Exception;
use Parsers\Youtube\YoutubeChannelDataParser;
use Parsers\Youtube\YoutubeVideoDataParser;

class YoutubeClient
{
    private const YOUTUBE_API_KEY_CONFIG_KEY = 'youtube_api_key';
    private const YOUTUBE_API_URL            = 'https://youtube.googleapis.com/youtube/v3';
    private const MAX_RESULTS                = 50;

    private string $apiKey;

    public function __construct()
    {
        $config = Config::getInstance();

        $this->apiKey = $config->getItem(self::YOUTUBE_API_KEY_CONFIG_KEY);
    }

    public function getChannelData (string $channelId): ?ChannelDTO
    {
        $params = [
            'part'  => 'snippet',
            'order' => 'date',
            'id'    => $channelId,
            'key'   => $this->apiKey,
        ];

        $url      = $this->generateURL('channels', $params);
        $response = $this->sendRequest($url);

        $parser = new YoutubeChannelDataParser();

        return $parser->parse($response);
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

    public function getChannelVideos (string $channelId): array
    {
        $result = [];

        $videosIdList = $this->getVideosIdList($channelId);

        foreach ($videosIdList as $videoId)
        {
            // тут запрашиваем инфо о видео и кидаем в парсер, чтобы получить DTO
        }

        return $result;
    }

    private function getVideosIdList(string $channelId): array
    {
        $params = [
            'part'      => 'snippet',
            'order'     => 'date',
            'channelId' => $channelId,
            'key'       => $this->apiKey,
            'maxResults' => self::MAX_RESULTS,
        ];

        $url      = $this->generateURL('search', $params);
        $response = $this->sendRequest($url);

        $parser = new YoutubeVideoDataParser();

        return $parser->parseVideosIdList($response);
    }
}