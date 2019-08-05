<?php

declare(strict_types=1);

namespace app;

use Google_Service_YouTube_SearchResult;

class YoutubeFetch
{
    /**
     * @var \Google_Service_YouTube
     */
    private $client;

    public function __construct(\Google_Service_YouTube $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $channelId
     * @return Channel
     */
    public function fetchChannelWithVideos(string $channelId): Channel
    {
        $channel = new Channel();
        $channel->setId($channelId);

        $channelInfo = $this->getChannelInfoById($channelId);

        if (!$channelInfo) {
            return $channel;
        }

        $channel->setTitle($channelInfo->getSnippet()->getTitle());

        $videoIds = $this->getVideoIdsByChannel($channelId);

        $videosWithStats = $this->client->videos->listVideos('snippet,statistics,contentDetails', [
            'id' => join(',', $videoIds)
        ]);

        foreach ($videosWithStats->getItems() as $video) {
            /**
             * @var \Google_Service_YouTube_Video $video
             */

            $statistics = $video->getStatistics();

            $stats = new Stats();
            $stats->likes = (int) $statistics->getLikeCount();
            $stats->dislikes = (int) $statistics->getDislikeCount();
            $stats->views = (int) $statistics->getViewCount();
            $stats->commentsCount = (int) $statistics->getCommentCount();

            $appVideo = new Video([
                'id' => $video->getId(),
                'title' => $video->getSnippet()->getTitle(),
                'duration' => Video::convertISO8601ToSeconds($video->getContentDetails()->getDuration()),
                'stats' => $stats,
                'publishedAt' => $video->getSnippet()->getPublishedAt()
            ]);

            $channel->addVideo($appVideo);
        }

        return $channel;
    }

    /**
     * @param string $channelId
     * @return \Google_Service_YouTube_Channel|null
     */
    private function getChannelInfoById(string $channelId): ?\Google_Service_YouTube_Channel
    {
        $queryParams = [
            'id' => $channelId
        ];

        $response = $this->client->channels->listChannels('snippet', $queryParams);

        if ($response->getPageInfo()->totalResults === 0) {
            return null;
        }

        return $response->getItems()[0];
    }

    /**
     * @param string $channelId
     * @return array
     */
    private function getVideoIdsByChannel(string $channelId): array
    {
        $nextPageToken = null;
        $videoIds = [];

        do {
            $queryParams = [
                'channelId' => $channelId,
                'type' => 'video',
            ];

            if ($nextPageToken) {
                $queryParams['pageToken'] = $nextPageToken;
            }
            $videos = $this->client->search->listSearch('id', $queryParams);
            foreach ($videos as $video) {
                /**
                 * @var Google_Service_YouTube_SearchResult $video
                 */
                $videoIds[] = $video->getId()->videoId;
            }
        } while (!empty($nextPageToken = $videos->getNextPageToken()));

        return $videoIds;
    }
}