<?php declare(strict_types=1);

namespace Controller;

use Entity\Youtube\Channel;
use Entity\Youtube\Video;
use Service\SelfApiClient;
use Service\YoutubeApiClient;

class SpiderController
{
    public function runAction(array $arguments): void
    {
        if ($arguments[0] === null) {
            throw new \RuntimeException('Вы должны передать параметр - поисковой запрос');
        }
        $query = $arguments[0];
        $maxResults = (int)($arguments[1] ?? 10);
        $youtubeApiClient = new YoutubeApiClient();
        $selfApiClient = new SelfApiClient();

        $channels = $youtubeApiClient->getChannelsList($query, $maxResults);
        foreach ($channels['items'] ?? [] as $channel) {
            $channelEntity = new Channel();
            $channelEntity->setChannelId($channel['id']['channelId']);
            $channelEntity->setTitle($channel['snippet']['title']);

            $videoEntities = [];
            $videos = $youtubeApiClient->getVideosList($channelEntity->getChannelId(), $maxResults);
            foreach ($videos['items'] ?? [] as $video) {
                $videoEntity = new Video();
                $videoEntity->setVideoId($video['id']['videoId']);
                $videoEntity->setTitle($video['snippet']['title']);

                $statistics = $youtubeApiClient->getVideoStatistics($videoEntity->getVideoId());
                if ($statistics !== null) {
                    $videoEntity->setLikes((int)$statistics['statistics']['likeCount']);
                    $videoEntity->setDislikes((int)$statistics['statistics']['dislikeCount']);
                }
                $videoEntities[] = $videoEntity;
            }
            $channelEntity->setVideos($videoEntities);

            $response = $selfApiClient->postChannel($channelEntity);
            echo $response->getStatusCode() . PHP_EOL;
        }
    }
}
