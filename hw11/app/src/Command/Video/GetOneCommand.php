<?php

declare(strict_types=1);

namespace App\Command\Video;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Video\Repository\VideoRepositoryInterface;
use InvalidArgumentException;

class GetOneCommand implements CommandInterface
{

    private VideoRepositoryInterface $videoRepository;

    public function __construct(VideoRepositoryInterface $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function execute(): void
    {
        $videoId = Console::getArgument(2);

        $this->throwExceptionIfVideoIdIsNotSpecified($videoId);

        $video = $this->videoRepository->getOne($videoId);

        Console::success('Информация о видео получена: ' . PHP_EOL . print_r($video->toArray(), true));
    }

    private function throwExceptionIfVideoIdIsNotSpecified(string $videoId): void
    {
        if (empty($videoId)) {
            throw new InvalidArgumentException('Не указан id видео');
        }
    }

}