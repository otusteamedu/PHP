<?php

namespace App\Model\Service;

use App\Core\ConfigInterface;

class Youtube implements VideoServiceInterface
{

    private \Google_Client $client;
    private \Google_Service_YouTube $service;

    public function __construct(ConfigInterface $config)
    {
        $this->client = new \Google_Client();
        $this->client->setApplicationName($config->get('youtube.appName'));
        $this->client->setDeveloperKey($config->get('youtube.devKey'));
        $this->service = new \Google_Service_YouTube($this->client);
    }

    public function getVideosOnChannel(array $channelIds): array
    {
        $channels = $this->getChannels($channelIds);
        $videoIds = [];
        foreach ($channels as $channel) {
            if (!isset($videoIds[$channel->getId()])) {
                $videoIds[$channel->getId()] = [];
            }
            $uploads = $channel->getContentDetails()->getRelatedPlaylists()->getUploads();
            $pageToken = null;
            while ($pageToken !== false) {
                $list = $this->service->playlistItems->listPlaylistItems(['contentDetails'], [
                    'playlistId' => $uploads,
                    'maxResults' => 50,
                    'pageToken' => $pageToken,
                ]);
                foreach ($list->getItems() as $video) {
                    $videoIds[$channel->getId()][] = $video->getContentDetails()->getVideoId();
                }
                $pageToken = $list->getNextPageToken() ?: false;
            }
        }
        return $videoIds;
    }


    public function getVideosStatistics(array $videoIds): array
    {
        $videosStats = $this->service->videos->listVideos(['snippet', 'statistics'], [
            'id' => implode(',', $videoIds)
        ]);
        $data = [];
        foreach ($videosStats->getItems() as $videoStat) {
            $key = $videoStat->getId();
            $data[$key] = $videoStat;
//            $data[$key] = [
//                'title' => $videoStat->getSnippet()->getTitle(),
//                'likes' => $videoStat->getStatistics()->getLikeCount(),
//                'dis' => $videoStat->getStatistics()->getDislikeCount(),
//            ];
        }
        return $data;
    }

    /**
     * @param array $channelIds
     * @return \Google_Service_YouTube_Channel[]
     */
    public function getChannels(array $channelIds): array
    {
        return $this->service->channels->listChannels(['contentDetails', 'snippet'], [
            'id' => implode(',', $channelIds),
        ])->getItems();
    }

}