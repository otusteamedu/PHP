<?php

declare(strict_types=1);

namespace App\Command\Channel;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Channel\Repository\ChannelRepositoryInterface;
use InvalidArgumentException;

class GetOneCommand implements CommandInterface
{

    private ChannelRepositoryInterface $channelRepository;

    public function __construct(ChannelRepositoryInterface $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    public function execute(): void
    {
        $channelId = Console::getArgument(2);

        $this->throwExceptionIfChannelIdIsNotSpecified($channelId);

        $channel = $this->channelRepository->getOne($channelId);

        Console::success('Информация о канале получена:');
        Console::success(print_r($channel->toArray(), true));
    }

    private function throwExceptionIfChannelIdIsNotSpecified(string $channelId): void
    {
        if (empty($channelId)) {
            throw new InvalidArgumentException('Не указан id канала');
        }
    }

}