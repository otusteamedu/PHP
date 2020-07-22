<?php

namespace Services;

interface ChannelStatisticServiceInterface
{
    public function getTotalChannelVideosLikesNumber(string $channelId, int $limit);

    public function getTopChannelsWithBestLikesDislikeRation(int $limit);
}
