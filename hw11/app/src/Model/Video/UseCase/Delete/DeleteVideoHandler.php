<?php

declare(strict_types=1);

namespace App\Model\Video\UseCase\Delete;

use App\Model\Video\Repository\VideoRepositoryInterface;

class DeleteVideoHandler
{

    private VideoRepositoryInterface $videoRepository;

    public function __construct(VideoRepositoryInterface $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function handle(DeleteVideoCommand $command): void
    {
        $video = $this->videoRepository->getOne($command->id);

        $this->videoRepository->delete($video);
    }

}