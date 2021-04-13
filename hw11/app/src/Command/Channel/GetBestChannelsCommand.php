<?php

declare(strict_types=1);

namespace App\Command\Channel;

use App\Command\CommandInterface;
use App\Console\Console;
use App\ReadModel\Channel\ChannelStatsFetcher;
use InvalidArgumentException;

class GetBestChannelsCommand implements CommandInterface
{

    private ChannelStatsFetcher $channelStatsFetcher;

    public function __construct(ChannelStatsFetcher $channelStatsFetcher)
    {
        $this->channelStatsFetcher = $channelStatsFetcher;
    }

    public function execute(): void
    {
        $numberOfChannels = intval(Console::getArgument(2));

        $this->throwExceptionIfNumberOfChannelsIsNotSpecified($numberOfChannels);

        $bestChannels = $this->channelStatsFetcher->getBestChannels($numberOfChannels);

        Console::success("Топ $numberOfChannels каналов с лучшим соотношением кол-во лайков/кол-во дизлайков:");
        Console::success(implode(PHP_EOL, $bestChannels));
    }

    private function throwExceptionIfNumberOfChannelsIsNotSpecified(int $numberOfChannels): void
    {
        if ($numberOfChannels <= 0) {
            throw new InvalidArgumentException('Не указано количество каналов');
        }
    }

}
