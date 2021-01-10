<?php

namespace VideoPlatform\platforms;

use VideoPlatform\interfaces\VideoSharingPlatformInterface;

class Youtube implements VideoSharingPlatformInterface
{
    private $apiKey;

    public function __construct()
    {

    }

    public function getChannelDetail(): array
    {
        return [];
    }

    public function getVideoDetail(): array
    {
        return [];
    }

    public function getConfig(): array
    {
        return [];
    }
}
