<?php

namespace App\Model\Service;

interface VideoServiceInterface
{
    public function getChannels(array $channelIds): array;

    public function getVideosOnChannel(array $channelIds): array;

    public function getVideosStatistics(array $videoIds): array;
}