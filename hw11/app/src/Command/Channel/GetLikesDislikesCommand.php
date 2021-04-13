<?php

declare(strict_types=1);

namespace App\Command\Channel;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Channel\Repository\ChannelRepositoryInterface;
use App\ReadModel\Channel\ChannelStatsFetcher;
use InvalidArgumentException;

class GetLikesDislikesCommand implements CommandInterface
{

    private ChannelRepositoryInterface $channelRepository;
    private ChannelStatsFetcher        $channelStatsFetcher;

    public function __construct(ChannelRepositoryInterface $channelRepository, ChannelStatsFetcher $channelStatsFetcher)
    {
        $this->channelRepository = $channelRepository;
        $this->channelStatsFetcher = $channelStatsFetcher;
    }

    public function execute(): void
    {
        $channelId = Console::getArgument(2);

        $this->throwExceptionIfChannelIdIsNotSpecified($channelId);

        $channel = $this->channelRepository->getOne($channelId);

        $likeCount = $this->channelStatsFetcher->getLikeCountByChannel($channelId);
        $disLikeCount = $this->channelStatsFetcher->getDislikeCountByChannel($channelId);

        Console::success('Канал: ' . $channel->getTitle());
        Console::success('Суммарное количество лайков: ' . $likeCount);
        Console::success('Суммарное количество дизлайков: ' . $disLikeCount);
    }

    private function throwExceptionIfChannelIdIsNotSpecified(string $channelId): void
    {
        if (empty($channelId)) {
            throw new InvalidArgumentException('Не указан id канала');
        }
    }

}