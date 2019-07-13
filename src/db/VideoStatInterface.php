<?php

namespace crazydope\youtube\db;

use crazydope\youtube\ChannelInterface;

interface VideoStatInterface
{
    public function getChannelVideoStats(ChannelInterface $channel): ?string;

    public function getTopRatedChannels(GetChannelInterface $storage): array;
}