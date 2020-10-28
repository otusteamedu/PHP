<?php

namespace App\Repositories\YouTube;

use Illuminate\Support\Collection;

class YouTubeStatisticsRepository {
    private \App\Interfaces\YouTube\YouTubeRepositoryInterface $youtubeChannelRep;
    private \App\Interfaces\YouTube\YouTubeRepositoryInterface $youtubeVideoRep;

    public function __construct() {
        $this->youtubeChannelRep = app(\App\Repositories\YouTube\YouTubeChannelRepository::class);
        $this->youtubeVideoRep = app(\App\Repositories\YouTube\YouTubeVideoRepository::class);
    }

    public function getStatisticByChannelName(string $name) {
        $channel = $this->youtubeChannelRep->search($name)->first();
        $videos = $this->youtubeVideoRep->search($channel->channel_id);
        $likes = $dislikes = 0;
        foreach ($videos as $video) {
            $likes += $video->likes_count;
            $dislikes += $video->dislikes_count;
        }
        $data = [
            'channel_name' => $channel->name,
            'likes' => $likes,
            'dislikes' => $dislikes,
        ];

        return $data;
    }

    public function getTopChannelsByDifferenceLikesDislikes() {
        $channels = $this->youtubeChannelRep->getAll();
        $result = [];
        foreach ($channels as $channel) {
            $likes = $dislikes = 0;
            $videos = $this->youtubeVideoRep->search($channel['channel_id']);
            foreach ($videos as $video) {
                $likes += $video->likes_count;
                $dislikes += $video->dislikes_count;
            }
            $result[$channel['name']]['likes'] = $likes;
            $result[$channel['name']]['dislikes'] = $dislikes;
            $result[$channel['name']]['rate'] = $likes/$dislikes;

        }

        uasort($result, function ($a, $b) { return $b['rate'] - $a['rate']; });
        return $result;
    }
}
