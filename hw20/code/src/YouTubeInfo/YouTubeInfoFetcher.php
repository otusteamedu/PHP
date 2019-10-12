<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */


namespace APP\YouTubeInfo;

use GuzzleHttp\Client;

class YouTubeInfoFetcher
{
    private const API_KEY = "AIzaSyBcQ6WpkRBidxPhOySMw79Gcw5CcxC-pEs";
    private const MAX_VIDEO_PER_CHANNEL_COUNT = 10; // ограничил, чтобы не превысить квоту

    private $userName;
    private $channelName;
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function getChannelInfo(): ?YouTubeChannelInfo
    {
        $channelId = $this->getChannelIdByName();
        if ($channelId !== null) {
            return $this->getChannelInfoByChannelId($channelId);
        }
    }

    private function getChannelIdByName(): ?string
    {
        $channelInfoParameters = [
            "query" => [
                "part" => "id,snippet",
                "forUsername" => $this->userName,
                "key" => self::API_KEY
            ]
        ];

        $channelRequest = $this->client->request("GET", "https://www.googleapis.com/youtube/v3/channels",
            $channelInfoParameters);

        $body = json_decode((string)$channelRequest->getBody());
        $this->channelName = $this->getChannelNameFromBody($body);
        return $this->getChannelIdFromBody($body);
    }

    private function getChannelInfoByChannelId(string $channelId): YouTubeChannelInfo
    {
        $channelInfo = new YouTubeChannelInfo($this->userName);

        $videoInfoParameters = [
            "query" => [
                "part" => "id,snippet",
                "channelId" => $channelId,
                "key" => self::API_KEY,
                "maxResults" => self::MAX_VIDEO_PER_CHANNEL_COUNT
            ]
        ];

        $videoRequest = $this->client->request("GET", "https://www.googleapis.com/youtube/v3/search",
            $videoInfoParameters);
        $body = json_decode((string)$videoRequest->getBody());
        $videos = $this->getListOfVideosFromBody($body);

        foreach ($videos as $video) {
            $videoId = $this->getVideoId($video);
            if ($videoId === null) {
                continue;
            }
            $statInfoParameters = [
                "query" => [
                    "part" => "statistics",
                    "id" => $this->getVideoId($video),
                    "key" => self::API_KEY
                ]
            ];

            $statsRequest = $this->client->request("GET", "https://www.googleapis.com/youtube/v3/videos",
                $statInfoParameters);
            $body = json_decode((string)$statsRequest->getBody());
            $stats = $this->getVideoStatsFromBody($body);

            $channelInfo->addVideoInfo(
                new YouTubeVideoInfo($this->getVideoTitle($video), (int)$stats->likeCount, (int)$stats->dislikeCount)
            );
        }
        return $channelInfo;
    }

    private function getChannelIdFromBody(\stdClass $body): string
    {
        return $body->items[0]->id;
    }

    private function getChannelNameFromBody(\stdClass $body): string
    {
        return $body->items[0]->snippet->title;
    }

    private function getListOfVideosFromBody(\stdClass $body): array
    {
        return $body->items;
    }

    private function getVideoStatsFromBody(\stdClass $body): \stdClass
    {
        return $body->items[0]->statistics;
    }

    private function getVideoTitle(\stdClass $video): string
    {
        return $video->snippet->title;
    }

    private function getVideoId(\stdClass $video): ?string
    {
        return $video->id->videoId;
    }
}