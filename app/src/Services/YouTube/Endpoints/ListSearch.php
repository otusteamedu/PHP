<?php


namespace App\Services\YouTube\Endpoints;

use App\Services\YouTube\Exceptions\YouTubeApiBadResponseException;
use Google_Service_YouTube_SearchListResponse;

class ListSearch extends BaseEndpoint
{
    /**
     * @param string $part
     * @param array $params
     * @return Google_Service_YouTube_SearchListResponse
     * @throws YouTubeApiBadResponseException
     */
    public function execute(string $part, array $params): Google_Service_YouTube_SearchListResponse
    {
        $response = $this->client->search->listSearch($part, $params);

        if($response instanceof Google_Service_YouTube_SearchListResponse){
            return $response;
        }

        $this->throwBadResponseException($response, Google_Service_YouTube_SearchListResponse::class);
    }
}