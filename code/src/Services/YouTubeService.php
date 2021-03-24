<?php

namespace App\Services;


use Google_Client;
use Google_Service_YouTube;
use Google_Service_YouTube_ChannelListResponse;
use Google_Service_YouTube_SearchListResponse;
use Google_Service_YouTube_VideoListResponse;


class YouTubeService
{
    protected Google_Client $client;
    protected Google_Service_YouTube $service;

    /**
     * YouTubeService constructor.
     */
    public function __construct()
    {
        $client = new Google_Client();
        $client->setDeveloperKey(getenv('GOOGLE_API_KEY'));

        $this->service = new Google_Service_YouTube($client);
    }


    public function search(string $query, $maxResults = 10, $type = 'channel'): Google_Service_YouTube_SearchListResponse
    {
        $queryParams = [
            'maxResults' => $maxResults,
            'q' => $query,
            'type' => $type,
        ];

        return $this->service->search->listSearch('snippet', $queryParams);
    }

    public function findChannelById(string $id): Google_Service_YouTube_ChannelListResponse
    {
        return $this->service->channels
            ->listChannels('snippet,contentDetails,statistics', ['id' => $id]);
    }

    public function findChannelVideos(string $channelId, $maxResults): Google_Service_YouTube_SearchListResponse
    {
        $queryParams = [
            'channelId' => $channelId,
            'maxResults' => $maxResults,
            'type' => 'video'
        ];

        return $this->service->search->listSearch('snippet', $queryParams);
    }

    public function findVideo(string $id): Google_Service_YouTube_VideoListResponse
    {
         $queryParams = [
            'id' => $id,
        ];

        return $this->service->videos->listVideos('snippet,contentDetails,statistics', $queryParams);
    }
}

