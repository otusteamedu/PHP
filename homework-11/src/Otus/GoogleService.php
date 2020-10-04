<?php

namespace Otus;

use Google_Client;
use Google_Service_YouTube;

class GoogleService
{
    private Google_Service_YouTube $service;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setAuthConfig(__DIR__.'/../../'.$_ENV['AUTH_CONFIG_FILE']);
        $client->setAccessType('offline');
        $client->addScope('https://www.googleapis.com/auth/youtube.readonly');

        $this->service = new Google_Service_YouTube($client);
    }

    public function getChannel(string $id): array
    {
        $channels = $this->service->channels->listChannels('contentDetails,snippet', [
            'id' => $id,
        ]);

        $channelData = [];
        foreach ($channels->items as $channel) {
            $channelData = [
                'id'               => $channel->id,
                'title'            => $channel->snippet->title,
                'description'      => $channel->snippet->description,
            ];

            do {
                $playlists = $this->service->playlistItems->listPlaylistItems('contentDetails', [
                    'playlistId' => $channel->contentDetails->relatedPlaylists->uploads,
                    'maxResults' => 50,
                    'pageToken'  => $playlists->nextPageToken ?? '',
                ]);

                $videoIds = [];
                foreach ($playlists->items as $playlist) {
                    $videoIds[] = $playlist->contentDetails->videoId;
                }

                $videos = $this->service->videos->listVideos('statistics', [
                    'id' => implode(',', $videoIds),
                ]);
                foreach ($videos->items as $video) {
                    $channelData['like_count'] += $video->statistics->likeCount;
                    $channelData['dislike_count'] += $video->statistics->dislikeCount;
                }
            } while ($playlists->nextPageToken);

            $channelData['ratio'] = $this->calculateRatio($channelData['like_count'], $channelData['dislike_count']);
        }

        return $channelData;
    }

    private function calculateRatio(int $likeCount, int $dislikeCount): float
    {
        if ($likeCount === 0) {
            return 0;
        }

        if ($dislikeCount === 0) {
            return 1;
        }

        return round($dislikeCount / $likeCount, 4);
    }
}