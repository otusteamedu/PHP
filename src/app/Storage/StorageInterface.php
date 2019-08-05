<?php

declare(strict_types=1);

namespace app\Storage;

use app\Channel\Collection;
use app\{Channel, Stats};

interface StorageInterface
{
    public function insertChannel(Channel $channel): bool;
    public function getTopChannels(int $limit): Collection;
    public function getChannelStats(string $channelId): Stats;
}