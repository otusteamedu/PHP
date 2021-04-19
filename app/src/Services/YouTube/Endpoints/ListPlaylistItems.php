<?php

namespace App\Services\YouTube\Endpoints;

use App\Services\YouTube\Exceptions\YouTubeApiBadResponseException;
use Google_Service_YouTube_PlaylistItemListResponse;

class ListPlaylistItems extends BaseEndpoint
{
    /**
     * @param string $part
     * @param array $params
     * @return Google_Service_YouTube_PlaylistItemListResponse
     * @throws YouTubeApiBadResponseException
     */
    public function execute(string $part, array $params): Google_Service_YouTube_PlaylistItemListResponse
    {
        $response = $this->client->playlistItems->listPlaylistItems($part, $params);

        if($response instanceof Google_Service_YouTube_PlaylistItemListResponse){
            return $response;
        }

        $this->throwBadResponseException($response, Google_Service_YouTube_PlaylistItemListResponse::class);
    }
}