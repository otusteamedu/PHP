<?php

declare(strict_types=1);

namespace App\Command\Video;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Video\Repository\VideoRepositoryInterface;
use InvalidArgumentException;

class GetCommand implements CommandInterface
{

    private VideoRepositoryInterface $videoRepository;

    public function __construct(VideoRepositoryInterface $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function execute(): void
    {
        $channelId = Console::getArgument(2);
        $limit = intval(Console::getArgument(3));

        $this->throwExceptionIfChannelIdIsNotSpecified($channelId);
        $this->throwExceptionIfLimitIsNotSpecified($limit);

        if (!$videos = $this->videoRepository->get($channelId, $limit, 0)) {
            Console::info('Канал не содержит видео');

            return;
        }

        Console::success('Список видео получен: ');
        foreach ($videos as $video) {
            Console::info(print_r($video->toArray(), true));
        }
    }

    private function throwExceptionIfChannelIdIsNotSpecified(string $channelId): void
    {
        if (empty($channelId)) {
            throw new InvalidArgumentException('Не указан id канала');
        }
    }

    private function throwExceptionIfLimitIsNotSpecified(int $limit): void
    {
        if (empty($limit)) {
            throw new InvalidArgumentException('Не указано значения limit');
        }
    }

}