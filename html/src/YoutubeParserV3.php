<?php

namespace Ymdb;

class YoutubeParserV3
{
    private $config;
    private $youtube;
    const MAXRESULTS = 10;

    public function __construct($apikey)
    {
        $googleClient = new \Google_Client();
        $googleClient->setDeveloperKey($apikey);
        $this->youtube = new \Google_Service_YouTube($googleClient);

        $this->config["apikey"] = $apikey;
    }

    public function parseInfoChannel(string $channelId): array
    {
        $queryParams = [
            "id" => $channelId,
        ];

        $infoChannel = $this->youtube->channels->listChannels("snippet,statistics", $queryParams);
        $item = $infoChannel->toSimpleObject()->items[0];

        $arrChannel = [
            "_id" => (string) $item->id,
            "title" => (string) $item->snippet->title,
            "description" => (string) $item->snippet->description,
            "subscriberCount" => (int) $item->statistics->subscriberCount,
            "videoCount" => (int) $item->statistics->videoCount,
            "viewCount" => (int) $item->statistics->viewCount,
        ];

        return $arrChannel;
    }

    public function parseListVideoByChannel(string $channelId, $nextPage = null): array
    {
        $arrVideos["nextPage"] = null;
        $queryParams = [
            "channelId" => $channelId,
            "order" => "date",
            "maxResults" => self::MAXRESULTS,
            "type" => "video",
            "pageToken" => $nextPage,
        ];
        $listVideo = $this->youtube->search->listSearch("snippet", $queryParams)->toSimpleObject();
        $items = $listVideo->items;

        foreach ($items as $item) {
            $arrVideos["items"][] = [
                // "title" => $item->snippet->title,
                "videoId" => $item->id->videoId,
            ];
        }

        // В выдаче какая-то путаница со страницами и количеством видео,
        // поэтому такая лишняя проверка empty($items)
        if ($listVideo->nextPageToken && !empty($items)) {
            $arrVideos["nextPage"] = $listVideo->nextPageToken;
        }

        return $arrVideos;
    }

    public function parseInfoVideo(string $videoId): array
    {
        $queryParams = [
            "id" => $videoId,
        ];

        $infoVideo = $this->youtube->videos->listVideos("snippet,statistics,contentDetails", $queryParams);
        $item = $infoVideo->toSimpleObject()->items[0];

        $arrVideo = [
            "_id" => (string) $item->id,
            "channelId" => (string) $item->snippet->channelId,
            "channelTitle" => (string) $item->snippet->channelTitle,
            "publishedAt" => (string) $item->snippet->publishedAt,
            "title" => (string) $item->snippet->title,
            "description" => (string) $item->snippet->description,
            "tags" => (array) $item->snippet->tags,
            "duration" => (string) $item->contentDetails->duration,
            "viewCount" => (int) $item->statistics->viewCount,
            "likeCount" => (int) $item->statistics->likeCount,
            "dislikeCount" => (int) $item->statistics->dislikeCount,
            "commentCount" => (int) $item->statistics->commentCount,
        ];

        return $arrVideo;
    }

}
