<?php

namespace App\Services;

use Google_Client;
use Google_Service_YouTube;
use Google_Service_YouTube_SearchListResponse;


class YouTubeChannels
{
    protected Google_Client $client;
    protected Google_Service_YouTube $service;

    /**
     * YouTubeChannels constructor.
     */
    public function __construct()
    {
        $client = new Google_Client();
        $client->setDeveloperKey(getenv('GOOGLE_API_KEY'));

        $this->service = new Google_Service_YouTube($client);
    }

    public function findAll(): Google_Service_YouTube_SearchListResponse
    {
        $queryParams = [
            'maxResults' => 5,
            'q' => 'hightload'
        ];

        return $this->service->search->listSearch('snippet', $queryParams);
    }

    public function search(string $query): Google_Service_YouTube_SearchListResponse
    {
        $queryParams = [
            'maxResults' => 100,
            'q' => $query,
        ];

        return $this->service->search->listSearch('snippet', $queryParams);
    }


}
