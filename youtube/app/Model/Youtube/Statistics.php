<?php

namespace App\Model\Youtube;

use App\Model\Storage\YoutubeStorageInterface;

class Statistics
{

    private YoutubeStorageInterface $storage;

    public function __construct(YoutubeStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function getSummary(string $channelId): array
    {
//        return ['likes' => 1030, 'dislikes' => 22];
        return $this->storage->channelSummary($channelId);
    }

    public function getTop(int $number): array
    {
//        return [
//            ['name' => 'Channel name', 'ratio' => 20],
//            ['name' => 'Channel name 3', 'ratio' => 5],
//            ['name' => 'Channel name 2', 'ratio' => 0.5],
//        ];
        return $this->storage->topChannels($number);
    }

}
