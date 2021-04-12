<?php

declare(strict_types=1);

namespace App\Command\Channel;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Channel\Repository\ChannelRepositoryInterface;

class GetCommand implements CommandInterface
{

    private ChannelRepositoryInterface $channelRepository;

    public function __construct(ChannelRepositoryInterface $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    public function execute(): void
    {
        $limit = intval(Console::getArgument(2));

        if (!$channels = $this->channelRepository->get($limit, 0)) {
            Console::info('Список каналов пуст');

            return;
        }

        Console::success('Список каналов получен: ');
        foreach ($channels as $channel) {
            Console::info(print_r($channel->toArray(), true));
        }
    }

}