<?php

declare(strict_types=1);

namespace App\Drivers;

use App\Contracts\YouTubeDriver as YouTubeDriverInterface;
use App\Entities\{YouTubeCategory, YouTubeChannel, YouTubeVideo};
use Google_Client;
use Google_Service_YouTube;

class YouTubeDriver implements YouTubeDriverInterface
{
    /** @var Google_Client */
    private $client;
    /** @var Google_Service_YouTube */
    private $youTubeService;

    /**
     * @param Google_Client $client
     */
    public function __construct(Google_Client $client)
    {
        $this->client = $client;
        $this->youTubeService = new Google_Service_YouTube($this->client);
    }

    /**
     * @param string $regionCode
     * @return array
     */
    public function getRegionCategories(string $regionCode): array
    {
        $params = ['regionCode' => $regionCode];
        $response = $this->youTubeService->guideCategories->listGuideCategories('snippet', $params);

        return array_map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->snippet->title,
            ];
        }, $response['items']);
    }

    /**
     * @inheritDoc
     */
    public function getCategoryChannels(YouTubeCategory $category): array
    {
        $params = ['categoryId' => $category->getId()];

        $channels = [];

        $loop = true;
        while ($loop) {
            $response = $this->youTubeService->channels->listChannels('snippet', $params);

            foreach ($response['items'] as $item) {
                $channels[] = (new YouTubeChannel())
                    ->setId($item->id)
                    ->setTitle($item->snippet->title)
                    ->setDescription($item->snippet->description)
                    ->setCategoryId($category->getId())
                    ->setCategoryTitle($category->getTitle());
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
     * @param string $channelId
     * @return YouTubeVideo[]
     */
    public function getChannelVideos(string $channelId): array
    {
        $params = ['channelId' => $channelId, 'type' => 'video'];
        $videos = [];

        $response = $this->youTubeService->search->listSearch('snippet', $params);

        $videoIds = array_map(function ($item) {
            return $item->id->videoId;
        }, $response['items']);

        $channelVideoStatistics = $this->getVideoStatistics($videoIds);

        foreach ($response['items'] as $item) {
            $video = new YouTubeVideo;
            $video->setId($item->id->videoId)
                ->setTitle($item->snippet->title)
                ->setDescription($item->snippet->description);
            $statistics = $channelVideoStatistics[$item->id->videoId];
            $video->setViewsCount($statistics['viewsCount'])
                ->setLikeCount($statistics['likeCount'])
                ->setDislikeCount($statistics['dislikeCount'])
                ->setCommentCount($statistics['commentCount']);

            $videos[] = $video;
        }

        return $videos;
    }

    /**
     * @inheritDoc
     */
    public function getVideoStatistics($videoId): array
    {
        if (is_array($videoId)) {
            $ids = implode(', ', $videoId);
        } else {
            $ids = $videoId;
        }

        $params = ['id' => $ids];

        $response = $this->youTubeService->videos->listVideos('statistics', $params);

        $items = [];

        foreach ($response['items'] as $item) {
            $items[$item->id] = [
                'viewsCount' => intval($item->statistics->viewCount),
                'likeCount' => intval($item->statistics->likeCount),
                'dislikeCount' => intval($item->statistics->dislikeCount),
                'commentCount' => intval($item->statistics->commentCount)
            ];
        }

        return $items;
    }
}
