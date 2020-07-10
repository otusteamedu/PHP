<?php


namespace YoutubeApp;


class ChannelsStatistic extends ChannelsModel
{
    public function getLikesStatisticsByChannelName(string $channelName): int
    {
        $channel = $this->getChannelByName($channelName);
        $likes = 0;
        foreach ($channel['videos'] as $video) {
            $likes += $video['likes'];
        }
        return $likes;
    }

    public function getDislikesStatisticsByChannelName(string $channelName): int
    {
        $channel = $this->getChannelByName($channelName);
        $dislikes = 0;
        foreach ($channel['videos'] as $film) {
            $dislikes += $film['dislikes'];
        }
        return $dislikes;
    }

    public function getTopChannelsStatistics(int $count): array
    {
        $topChannels = [];
        foreach ($this->getAllData() as $channel) {
            $channelName = $channel['name'];
            $topChannels[$channelName] = $this->getLikesStatisticsByChannelName($channelName) / $this->getDislikesStatisticsByChannelName($channelName);
        }
        arsort($topChannels);
        return array_slice($topChannels, 0, $count);
    }
}