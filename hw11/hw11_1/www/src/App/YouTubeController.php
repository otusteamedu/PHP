<?php

namespace App;

class YoutubeController
{
    /**
     * @param string $channelLogin
     */
    public function saveChannel(string $channelLogin): void
    {
        $fetcher = new YouTubeChannelInfoFetcher();
        $channelInfo = $fetcher->getChannelInfoByLogin($channelLogin);
        $youTubeChannel = new YouTubeChannel();
        $youTubeChannel->setId($channelInfo->items[0]->id);
        $youTubeChannel->setLogin($channelLogin);
        $youTubeChannel->setTitle($channelInfo->items[0]->snippet->title);
        $youTubeChannel->setDescription($channelInfo->items[0]->snippet->description);

        $channelVideoId = $fetcher->getChannelVideoIds($youTubeChannel->getId());
        $youTubeChannel->setVideoIds($channelVideoId);
        $youTubeChannel->save();
    }

    /**
     * @param string $channelLogin
     */
    public function saveVideosChannel(string $channelLogin): void
    {
        $fetcher = new YouTubeChannelInfoFetcher();
        $youTubeVideo = new YouTubeVideo();
        $channel = YouTubeChannel::getByLogin($channelLogin);

        $channelVideoId = $channel->getVideoIds();
        if ($channelVideoId) {
            foreach ($channelVideoId as $video) {
                $channelVideoStatistics = $fetcher->getVideosStatistic($video);
                $youTubeVideo->setId($channelVideoStatistics->items[0]->id);
                $youTubeVideo->setChannelId($channel->getId());
                $youTubeVideo->setDescription($channelVideoStatistics->items[0]->snippet->description);
                $youTubeVideo->setTitle($channelVideoStatistics->items[0]->snippet->title);
                $youTubeVideo->setLike($channelVideoStatistics->items[0]->statistics->likeCount);
                $youTubeVideo->setDislike($channelVideoStatistics->items[0]->statistics->dislikeCount);
                $youTubeVideo->save();
            }
        }
    }

    /**
     * @param string $channelLogin
     * @return array
     */
    public function chanelAllVideoStatistic($channelLogin): array
    {
        $sumLike = 0;
        $sumDisLike = 0;
        $channel = YouTubeChannel::getByLogin($channelLogin);
        $videoId = $channel->getVideoIds();
        $channelTitle = $channel->getTitle();
        foreach ($videoId as $value) {
            $video = YouTubeVideo::getById($value);
            $sumLike += $video->getLike();
            $sumDisLike += $video->getDisLike();
        }
        return [
            'title' => $channelTitle,
            'likes' => $sumLike,
            'disLikes' => $sumDisLike,
        ];
    }

    /**
     * @param int $topCount
     * @return array
     */
    public function topChanelStatistic($topCount): array
    {
        $topChannels = [];
        $channels =  YouTubeChannel::getAllData();
        foreach ($channels as $key => $channel) {
            $login = $channel['login'];
            $channelStatistic = $this->chanelAllVideoStatistic($login);
            $topChannels[$key]["title"] = $channelStatistic['title'];
            $topChannels[$key]["proportionLikeDisLike"] = $channelStatistic["likes"] / $channelStatistic["disLikes"];
            $topChannels[$key]["likes"] = $channelStatistic["likes"];
            $topChannels[$key]["disLikes"] = $channelStatistic["disLikes"];
        }
        usort($topChannels, array($this, "cmp"));

        return array_slice($topChannels, 0, $topCount);
    }

    private function cmp($a, $b)
    {
        return $b["proportionLikeDisLike"] > $a["proportionLikeDisLike"];
    }
}
