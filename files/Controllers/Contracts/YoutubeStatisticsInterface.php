<?php
namespace Controllers\Contracts;

interface YoutubeStatisticsInterface
{
    public function getChannelLikes(string $channelID): int;
    public function getChannelDislikes(string $channelID): int;
    public function getChannelLikeDifference(string $channelID): int;
    public function getMostRatingChannels(int $channelsAmount): array;
}