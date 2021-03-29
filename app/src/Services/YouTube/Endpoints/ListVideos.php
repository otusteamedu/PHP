<?php

namespace App\Services\YouTube\Endpoints;

use App\Services\YouTube\Exceptions\YouTubeApiBadResponseException;
use Google_Service_YouTube_VideoListResponse;

class ListVideos extends BaseEndpoint
{
    /**
     * @param string $part
     * @param array $params
     * @return Google_Service_YouTube_VideoListResponse
     * @throws YouTubeApiBadResponseException
     */
    public function execute(string $part, array $params): Google_Service_YouTube_VideoListResponse
    {
        $response = $this->client->videos->listVideos($part, $params);

        if($response instanceof Google_Service_YouTube_VideoListResponse){
            return $response;
        }

        $this->throwBadResponseException($response, Google_Service_YouTube_VideoListResponse::class);
    }
}