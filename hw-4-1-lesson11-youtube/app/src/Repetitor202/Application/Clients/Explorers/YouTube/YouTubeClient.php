<?php


namespace Repetitor202\Application\Clients\Explorers\YouTube;


use Exception;
use Repetitor202\Application\traits\RequestTrait;

class YouTubeClient
{
    use RequestTrait;

    private const BASE_URL = 'https://www.googleapis.com/youtube/v3';

    public function getChannel(string $id): array
    {
        $videos = [];
        $counter = 1;

        do {
            $channelApi = $this->searchChannelApi(
                $id,
                $channelApi['nextPageToken'] ?? null
            );

            echo $counter++ . ') nextPageToken - ' . $channelApi['nextPageToken'] . PHP_EOL;

            $videoIDs = '';

            foreach ($channelApi['items'] as $item) {
                if (isset($item['id']) && isset($item['id']['videoId'])) {
                    $videoIDs .= $item['id']['videoId'] . ',';

                    // TODO: get channelTitle
                    $title = $item['snippet']['channelTitle'];
                }
            }

            $videos = array_merge($videos, $this->getVideos($videoIDs));
        } while (! is_null($channelApi['nextPageToken']));

        return [
            'id' => $id,
            'title' => $title ?? '',
            'videos' => $videos,
        ];
    }

    public function getVideos(string $videoIDs): array
    {
        $videosApi = $this->getVideosApi($videoIDs);

        $videos = [];
        foreach ($videosApi['items'] as $videoApi) {
            if(! $this->validateVideo($videoApi)) {
                // TODO: write to log
                throw new Exception('Incorrect answer from youTube.');
            }

            $video = [];
            $video['id'] = $videoApi['id'];
            $video['channelId'] = $videoApi['snippet']['channelId'];
            $video['title'] = $videoApi['snippet']['title'];
            $video['likeCount'] = $videoApi['statistics']['likeCount'];
            $video['dislikeCount'] = $videoApi['statistics']['dislikeCount'];
            $videos[] = $video;
        }

        return $videos;
    }

    private function validateVideo(array $videoApi): bool
    {
        return !(
            is_null($videoApi['id']) ||
            is_null($videoApi['snippet']) ||
            is_null($videoApi['snippet']['channelId']) ||
            is_null($videoApi['snippet']['title']) ||
            is_null($videoApi['statistics']) ||
            is_null($videoApi['statistics']['likeCount']) ||
            is_null($videoApi['statistics']['dislikeCount'])
        );
    }

    private function searchChannelApi(string $channelId, string $nextPageToken = null): ?array
    {
        $url = self::BASE_URL . '/search'
            . '?key=' . $_ENV['YOUTUBE_API_KEY']
            . '&channelId=' . trim($channelId)
            . '&part=id,snippet'
            . '&order=date'
            . '&maxResults=20';

        if (! is_null($nextPageToken)) {
            $url .= '&pageToken=' . $nextPageToken;
        }

        $channel = $this->sendRequest('GET', $url);

        if(is_null($channel) || is_null($channel['items'])) {
            // TODO: write to log
            throw new Exception('Bad request.');
        }

        return $channel;
    }

    private function getVideosApi(string $videoIDs): array
    {
        $url = self::BASE_URL . '/videos'
            . '?key=' . $_ENV['YOUTUBE_API_KEY']
            . '&part=snippet,statistics'
            . '&id=' . trim($videoIDs);

        $videos = $this->sendRequest('GET', $url);

        if(is_null($videos) || is_null($videos['items'])) {
            // TODO: write to log
            throw new Exception('Bad request.');
        }

        return $videos;
    }
}