<?php

declare(strict_types=1);

namespace App\Model\Channel\UseCase\Delete;

use App\Model\Channel\Repository\ChannelRepositoryInterface;
use App\Model\Video\Repository\VideoRepositoryInterface;
use InvalidArgumentException;

class DeleteChannelHandler
{

    private ChannelRepositoryInterface $channelRepository;
    private VideoRepositoryInterface   $videoRepository;

    public function __construct(
        ChannelRepositoryInterface $channelRepository,
        VideoRepositoryInterface $videoRepository
    ) {
        $this->channelRepository = $channelRepository;
        $this->videoRepository = $videoRepository;
    }

    public function handle(DeleteChannelCommand $command): void
    {
        $this->throwExceptionIfIdIsNotSpecified($command->id);

        $channel = $this->channelRepository->getOne($command->id);

        $this->videoRepository->deleteAllByChannel($command->id);

        $this->channelRepository->delete($channel);
    }

    private function throwExceptionIfIdIsNotSpecified(string $id): void
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Не указан id канала');
        }
    }

}