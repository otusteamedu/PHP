<?php

namespace App\Services\YouTube\Endpoints;

use App\Services\YouTube\Exceptions\YouTubeApiBadResponseException;
use Google_Service_YouTube_ChannelListResponse;

class ListChannels extends BaseEndpoint
{
    /**
     * @param string $part
     * @param array $params
     * @return Google_Service_YouTube_ChannelListResponse
     * @throws YouTubeApiBadResponseException
     */
    public function execute(string $part, array $params): Google_Service_YouTube_ChannelListResponse
    {
        $response = $this->client->channels->listChannels($part, $params);

        if($response instanceof Google_Service_YouTube_ChannelListResponse){
            return $response;
        }

        $this->throwBadResponseException($response, Google_Service_YouTube_ChannelListResponse::class);
    }
}