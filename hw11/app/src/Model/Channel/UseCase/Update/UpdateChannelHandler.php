<?php

declare(strict_types=1);

namespace App\Model\Channel\UseCase\Update;

use App\Model\Channel\Repository\ChannelRepositoryInterface;

class UpdateChannelHandler
{

    private ChannelRepositoryInterface $channelRepository;

    public function __construct(ChannelRepositoryInterface $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    public function handle(UpdateChannelCommand $command): void
    {
        $channel = $this->channelRepository->getOne($command->id);

        $channel->changeTitle($command->title);

        $this->channelRepository->update($channel);
    }

}