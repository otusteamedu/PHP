<?php

namespace App\Clients;

use App\Config\Config;
use App\Models\DTO\ChannelDTO;
use App\Models\DTO\VideoDTO;
use App\Parsers\YoutubeVideoDataParser;
use App\Parsers\YoutubeChannelDataParser;
use App\Request\CurlRequest;
use App\Request\Request;

class YoutubeClient
{
    private const YOUTUBE_API_KEY_CONFIG_KEY = 'youtube_api_key';
    private const YOUTUBE_API_URL            = 'https://youtube.googleapis.com/youtube/v3';
    private const MAX_RESULTS                = 50;

    private string $apiKey;

    private Request $request;

    public function __construct ()
    {
        $config = Config::getInstance();

        $this->request = new CurlRequest();

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
        $response = $this->request->getResponse($url);

        $parser = new YoutubeChannelDataParser();

        return $parser->parse($response);
    }

    private function generateURL (string $cmd, array $params): string
    {
        return self::YOUTUBE_API_URL . "/{$cmd}?" . http_build_query($params);
    }

    public function getChannelVideos (string $channelId): array
    {
        $result = [];

        $videosIdList = $this->getVideosIdList($channelId);

        foreach ($videosIdList as $videoId) {
            $params = [
                'fields' => 'items(id,snippet(channelId,title,categoryId),statistics)',
                'part'   => 'snippet,statistics',
                'id'     => $videoId,
                'key'    => $this->apiKey,
            ];

            $url      = $this->generateURL('videos', $params);
            $response = $this->request->getResponse($url);

            $parser   = new YoutubeVideoDataParser();
            $videoDTO = $parser->parseVideoData($response);

            if ($videoDTO instanceof VideoDTO) {
                $result[] = $videoDTO;
            }
        }

        return $result;
    }

    private function getVideosIdList (string $channelId): array
    {
        $params = [
            'part'       => 'snippet',
            'order'      => 'date',
            'channelId'  => $channelId,
            'key'        => $this->apiKey,
            'maxResults' => self::MAX_RESULTS,
        ];

        $url      = $this->generateURL('search', $params);
        $response = $this->request->getResponse($url);

        $parser = new YoutubeVideoDataParser();

        return $parser->parseVideosIdList($response);
    }
}