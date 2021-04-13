<?php

declare(strict_types=1);

namespace App\Model\Channel\UseCase\Add;

use App\Model\Channel\Entity\Channel;
use App\Model\Channel\Exception\ChannelAlreadyExistsException;
use App\Model\Channel\Repository\ChannelRepositoryInterface;

class AddChannelHandler
{

    private ChannelRepositoryInterface $channelRepository;

    public function __construct(ChannelRepositoryInterface $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    public function handle(AddChannelCommand $command): void
    {
        $channel = $this->buildChannel($command);

        $this->throwExceptionIfAlreadyExists($channel);

        $this->channelRepository->add($channel);
    }

    private function throwExceptionIfAlreadyExists(Channel $channel): void
    {
        if ($this->channelRepository->hasById($channel->getId())) {
            throw new ChannelAlreadyExistsException("Канал {$channel->getTitle()} уже добавлен");
        }
    }

    private function buildChannel(AddChannelCommand $command): Channel
    {
        return new Channel($command->id, $command->title);
    }

}