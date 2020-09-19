<?php

namespace Controllers;

use Exceptions\RestClientException;
use Model\YouTubeChannelModel;

class YouTubeAPIController
{
    protected $youtubeAPI;
    private $apiKey;

    public function __construct()
    {
        $this->youtubeAPI = new RestAPIController([
            'base_url' => "https://www.googleapis.com/youtube/v3"
        ]);
        $this->apiKey = $_ENV['YOUTUBE_API_KEY'];
    }

    /**
     * @param string $channelName
     * @return false|YouTubeChannelModel
     * @throws RestClientException
     */
    public function getData(string $channelName)
    {
        $result = $this->youtubeAPI->get('channels', [
            'part' => 'statistics',
            'key' => $this->apiKey,
            'forUsername' => $channelName
        ]);

        if ($result->info->http_code == 200) {
            $resultObj = $result->decodeResponse();
            if ($resultObj->pageInfo->totalResults !== 0) {
                return (new YouTubeChannelModel())
                    ->setName($channelName)
                    ->setViews($resultObj->items[0]->statistics->viewCount)
                    ->setCountVideo($resultObj->items[0]->statistics->videoCount);
            }
        }
        return false;
    }
}
