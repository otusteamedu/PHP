<?php

namespace App\Model\Storage;

use App\Model\Youtube\Channel;
use App\Model\Youtube\Video;

interface YoutubeStorageInterface
{
    public function channelSummary(string $channelId): array;

    public function topChannels(int $number): array;

    public function addChannel(Channel $channel): array;

    public function addVideo(Video $video): array;
}