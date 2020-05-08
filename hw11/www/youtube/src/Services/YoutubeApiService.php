<?php

namespace App\Services;

use App\Models\Channel;
use App\Models\Video;
use Buzz\Browser;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Class YoutubeClientService
 * @package App\Services
 */
class YoutubeApiService
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct(Client $client)
    {
        $this->apiKey = getenv('YOUTUBE_API_KEY');
        $this->client = $client;
    }

    public function getJsonChannels(string $query, string $url): array
    {
        $response = $this->client->get($url, [
            'query' => [
                'key' => $this->apiKey,
                'part' => 'snippet',
                'maxResults' => 10,
                'q' => $query,
                'regionCode' => 'ru',
                'type' => 'channel',
            ]
        ]);

        $channels = json_decode($response->getBody()->getContents(), true);

        $channelsEntities = [];

        foreach ($channels['items']  as $channel) {
            $entityChannel = new Channel();

            $entityChannel->setTitle($channel['snippet']['title']);
            $entityChannel->setChannelId($channel['id']['channelId']);

            $videos = $this->getVideos('https://www.googleapis.com/youtube/v3/search', $entityChannel->getChannelId());

            $entityChannel->setVideos($videos);

            $channelsEntities[] = $entityChannel->jsonSerialize();

        }

        return $channelsEntities;
    }

    public function getVideos(string $url, string $channelId): array
    {
        $response = $this->client->request('get', $url, [
            'query' => [
                'key' => $this->apiKey,
                'part' => 'snippet',
                'maxResults' => 5,
                'type' => 'video',
                'channelId' => $channelId,
            ]
        ]);

        $videos = json_decode($response->getBody()->getContents(), true);

        $videosEntities = [];

        foreach ($videos['items'] as $video) {
            $videoEntity = new Video();

            $videoEntity->setTitle($video['snippet']['title']);
            $videoEntity->setVideoId($video['id']['videoId']);

            $statistics = $this->getVideoStatistics('https://www.googleapis.com/youtube/v3/videos',$videoEntity->getVideoId());

            $videoEntity->setVideoStatistics($statistics);

            $videosEntities[] = $videoEntity;
        }



        return $videosEntities;
    }

    public function getVideoStatistics(string $url, string $videoId): array
    {
        $response = $this->client->request('get', $url, [
            'query' => [
                'key' => $this->apiKey,
                'part' => 'statistics',
                'id' => $videoId,
            ]
        ]);
        $statistics = json_decode($response->getBody()->getContents(), true)['items'];

        $statistics = $statistics[0];

        $statisticEntity = [
            'likes' => 0,
            'dislikes' => 0
        ];
        if ($statistics !== null) {
            $statisticEntity['likes'] = (int)$statistics['statistics']['likeCount'];
            $statisticEntity['dislikes'] = (int)$statistics['statistics']['dislikeCount'];
        }

        return $statisticEntity;
    }
}