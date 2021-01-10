<?php

namespace VideoPlatform\interfaces;

interface VideoSharingPlatformInterface
{
    public function getChannelDetail(): array;

    public function getVideoDetail(): array;

    public function getConfig(): array;
}