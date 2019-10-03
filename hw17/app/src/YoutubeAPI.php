<?php
/**
* Class for work with Youtube API
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
namespace Jekys;

use \Google_Client;
use \Google_Service_YouTube;

class YoutubeAPI
{
    /**
    * @var object - stores Google API client
    */
    private $client;

    /**
    * @var object - stores Google Youtube API
    */
    private $service;

    /**
    * Object instance constructor
    *
    * @param string $appName - Google Cloud API App Name
    * @param array $scopes - Youtube API access scope
    * @param string $secretJsonPath - JSON file with Youtube API credentials
    *
    * @return void
    */

    public function __construct(string $appName, array $scopes, string $secretJsonPath)
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName($appName);
        $this->client->setScopes($scopes);
        $this->client->setAuthConfig($secretJsonPath);
        $this->client->setAccessType('offline');
        if ($this->client->isAccessTokenExpired()) {
            $this->client->refreshTokenWithAssertion();
        }
        $this->service = new Google_Service_YouTube($this->client);
    }
    /**
    * Returns the list of categories by region code
    *
    * @param string $regionCode
    *
    * @return array
    */

    public function getCategoriesByRegion(String $regionCode): array
    {
        $params = [
            'regionCode' => $regionCode
        ];
        $categories = [];
        $response = $this->service
            ->guideCategories
            ->listGuideCategories('snippet', $params);
        foreach ($response['items'] as $item) {
            $categories[] = [
                'id' => $item->id,
                'title' => $item->snippet->title
            ];
        }

        return $categories;
    }

    /**
    * Returns the list of channels for current category
    *
    * @param string $categoryId
    *
    * @return array
    */
    public function getChannelsByCatergory(String $categoryId): array
    {
        $params = [
            'categoryId' => $categoryId
        ];
        $channels = [];
        $loop = true;
        while ($loop) {
            $response = $this->service
                ->channels
                ->listChannels('snippet', $params);
            foreach ($response['items'] as $item) {
                $channels[$item->id] = [
                    'youtube_id' => $item->id,
                    'title' => $item->snippet->title,
                    'description' => $item->snippet->description,
                    'videos' => []
                ];
            }
            if (!$response->nextPageToken) {
                $loop = false;
            } else {
                $params['pageToken'] = $response->nextPageToken;
            }
        }

        return $channels;
    }

    /**
     * Returns description for channel by its ID
     *
     * @param string $channelId
     *
     * @return void
     */

    public function getChannelById(string $channelId): array
    {
        $result = [];

        $params = [
            'id' => $channelId
        ];

        $response = $this->service
            ->channels
            ->listChannels('snippet', $params);

        $channel = $response['items'][0] ?? null;

        if (!empty($channel)) {
            $result = [
                'youtube_id' => $channel->id,
                'title' => $channel->snippet->title,
                'description' => $channel->snippet->description,
                'videos' => []
            ];
        }

        return $result;
    }

    /**
    * Returns the list of videos on the channel
    *
    * @param string $channelId
    *
    * @return array
    */
    public function getChannelVideos(String $channelId): array
    {
        $params = [
            'channelId' => $channelId,
            'type' => 'video'
        ];
        $videos = [];
        $response = $this->service
                ->search
                ->listSearch('snippet', $params);
        $videoIds = [];
        foreach ($response['items'] as $item) {
            $videos[$item->id->videoId] = [
                'id' => $item->id->videoId,
                'title' => $item->snippet->title,
                'description' => $item->snippet->description,
                'stats' => []
            ];
            $videoIds[] = $item->id->videoId;
        }
        $stats = $this->getStats($videoIds);
        foreach ($stats as $videoId => $stats) {
            $videos[$videoId]['stats'] = $stats;
        }

        return array_values($videos);
    }

    /**
    * Returns statistics for videos
    *
    * @param array $videoIds
    *
    * @return array
    */
    public function getStats(array $videoIds): array
    {
        $stats = [];
        $params = [
            'id' => implode(', ', $videoIds),
        ];
        $response = $this->service
                ->videos
                ->listVideos('statistics', $params);
        foreach ($response['items'] as $item) {
            $stats[$item->id] = [
                'viewsCount' => intval($item->statistics->viewCount),
                'likeCount' => intval($item->statistics->likeCount),
                'dislikeCount' => intval($item->statistics->dislikeCount),
                'commentCount' => intval($item->statistics->commentCount)
            ];
        }

        return $stats;
    }
}
