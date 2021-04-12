<?php

declare(strict_types=1);

namespace App\Service\YouTube;

use App\Service\YouTube\Dto\ChannelDto;
use App\Service\YouTube\Dto\VideoDto;
use App\Service\YouTube\Converter\YouTubeChannelConverter;
use App\Service\YouTube\Converter\YouTubeVideoConverter;
use Google_Service_YouTube;
use Google_Service_YouTube_Channel;
use Google_Service_YouTube_SearchResult;
use Google_Service_YouTube_Video;

class YouTubeClient
{

    private YouTubeChannelConverter $channelConverter;
    private YouTubeVideoConverter   $videoConverter;
    private Google_Service_YouTube  $googleServiceYoutube;

    public function __construct(
        Google_Service_YouTube $googleServiceYoutube,
        YouTubeChannelConverter $youTubeChannelConverter,
        YouTubeVideoConverter $videoConverter
    ) {
        $this->googleServiceYoutube = $googleServiceYoutube;
        $this->channelConverter = $youTubeChannelConverter;
        $this->videoConverter = $videoConverter;
    }

    public function getChannelById(string $channelId): ?ChannelDto
    {
        $queryParams = [
            'id' => $channelId,
        ];

        $channels = $this->getChannelsByParams($queryParams);

        return ($channels ? $this->channelConverter->toDto($channels[0]) : null);
    }

    /**
     * @param array $queryParams
     *
     * @return Google_Service_YouTube_Channel[]
     */
    private function getChannelsByParams(array $queryParams): array
    {
        $response = $this->googleServiceYoutube->channels->listChannels('snippet', $queryParams);

        return $response->getItems();
    }

    /**
     * @param string $channelId
     *
     * @return VideoDto[]
     */
    public function getVideos(string $channelId): array
    {
        if (!$videoIds = $this->getVideoIds($channelId, 20, 2)) {
            return [];
        }

        $videos = $this->getVideosData($videoIds);

        return array_map(
            fn($video) => $this->videoConverter->toDto($video),
            $videos
        );
    }

    /**
     * @param string $channelId
     * @param int    $maxResults
     * @param int    $maxNumberOfPages
     *
     * @return string[]
     */
    private function getVideoIds(string $channelId, int $maxResults, int $maxNumberOfPages = 0): array
    {
        $queryParams = [
            'channelId'  => $channelId,
            'maxResults' => $maxResults,
            'order'      => 'date',
            'type'       => 'video',
        ];

        $pageCount = 0;
        $videoIds = [];

        do {
            $response = $this->googleServiceYoutube->search->listSearch('id', $queryParams);

            $videoIds = array_merge($videoIds, $this->extractVideoIdsFromSearchResult($response->getItems()));

            $queryParams['pageToken'] = $response->getNextPageToken();

            $pageCount++;

        } while ($queryParams['pageToken'] and ($maxNumberOfPages and $pageCount < $maxNumberOfPages));

        return $videoIds;
    }

    /**
     * @param Google_Service_YouTube_SearchResult[] $searchResult
     *
     * @return array
     */
    private function extractVideoIdsFromSearchResult(array $searchResult): array
    {
        return array_map(
            fn($result) => $result->getId()->getVideoId(),
            $searchResult
        );
    }

    /**
     * @param array $videoIds
     *
     * @return Google_Service_YouTube_Video[]
     */
    private function getVideosData(array $videoIds): array
    {
        $queryParams = [
            'id' => implode(',', $videoIds),
        ];

        $response = $this->googleServiceYoutube->videos->listVideos('snippet, statistics', $queryParams);

        return $response->getItems();
    }

}