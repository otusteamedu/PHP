<?php

declare(strict_types=1);

namespace App\Model\Video\UseCase\Update;

use App\Model\Video\Repository\VideoRepositoryInterface;

class UpdateVideoHandler
{

    private VideoRepositoryInterface $videoRepository;

    public function __construct(VideoRepositoryInterface $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function handle(UpdateVideoCommand $command): void
    {
        $video = $this->videoRepository->getOne($command->id);

        $video->changeTitle($command->title);
        $video->changelikeCount($command->likeCount);
        $video->changeDislikeCount($command->dislikeCount);

        $this->videoRepository->update($video);
    }

}