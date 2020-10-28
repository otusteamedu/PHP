<?php

namespace App\Services\Api;

class YouTube {

    private const API_KEY = 'AIzaSyBVigb4kEy2YzsM7EwqkB6lhwRBgEKh1hI';
    private \Google_Client $client;
    private \Google_Service_YouTube $youtube;

    public function __construct() {
        $this->client = new \Google_Client();
        $this->client->setDeveloperKey(self::API_KEY);
        $this->youtube = new \Google_Service_YouTube($this->client);
    }

    public function getVideoByIds(array $videoIds) {
        $data = $this->youtube->videos->listVideos('snippet,statistics', ['id' => implode(',', $videoIds)]);
        $data = $data->getItems();

        $result = [];
        foreach ($data as $video) {
            /** @var \Google_Service_YouTube_Video $video */
            $result[$video->getId()] = [
                'title'    => $video->getSnippet()->getTitle(),
                'likes'    => $video->getStatistics()->getLikeCount(),
                'dislikes' => $video->getStatistics()->getDislikeCount(),
                'views'    => $video->getStatistics()->getViewCount(),
            ];
        }

        return $result;
    }

    public function getChannelInfo(array $filter) {
        try {
            $filter = $this->prepareFilter($filter);
        } catch (\App\Exceptions\YouTube\YouTubeWrongFilterByChannelException $e) {
            report($e);
        }
        $data = $this->youtube->channels->listChannels('snippet', $filter);
        $data = $data->getItems();

        $result = [];
        foreach ($data as $channel) {
            /** @var \Google_Service_YouTube_Channel $channel */
            $channel = $this->formatChannelInfo($channel);
            $result[$channel['channel_id']] = $channel;
        }

        return $result;
    }

    public function getChannelVideosById(string $channel_id) {
        $filter = [
            'channelId'  => $channel_id,
            'type'       => 'video',
            'maxResults' => 50,
        ];

        $data = $this->youtube->search->listSearch('snippet', $filter);
        $data = $data->getItems();

        $videoIds = [];
        foreach ($data as $result) {
            /** @var \Google_Service_YouTube_SearchResult $result */
            $videoIds[] = $result->getId()->getVideoId();
        }

        return $videoIds;
    }

    private function formatChannelInfo(\Google_service_YouTube_Channel $channel) {

        $title = $channel->getSnippet()->getTitle();

        $url = (!empty($channel->getSnippet()
            ->getCustomUrl()) ? sprintf('https://www.youtube.com/c/%s', $channel->getSnippet()
            ->getCustomUrl()) : sprintf('https://www.youtube.com/user/%s', $title));

        return [
            'channel_id'   => $channel->getId(),
            'channel_name' => $title,
            'custom_url'   => $url,
        ];
    }

    private function prepareFilter(array $filter) {
        $filter_res = [];

        if (isset($filter['name'])) {
            $filter_res['forUsername'] = $filter['name'];
        }

        if (isset($filter['id'])) {
            $filter_res['id'] = $filter['id'];
        }

        if (empty($filter_res)) {
            throw new \App\Exceptions\YouTube\YouTubeWrongFilterByChannelException();
        }

        return $filter_res;
    }

}
