<?php

declare(strict_types=1);

namespace app\Channel;

use app\Storage\StorageInterface;
use app\{Channel, Stats};

class Mapper
{
    /**
     * @var StorageInterface
     */
    private $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function getStorage(): StorageInterface
    {
        return $this->storage;
    }

    public function insertChannel(Channel $channel): bool
    {
        return $this->storage->insertChannel($channel);
    }

    public function getTopChannels(int $limit): Collection
    {
        return $this->storage->getTopChannels($limit);
    }

    public function getChannelStats(string $channelId): Stats
    {
        return $this->storage->getChannelStats($channelId);
    }
}