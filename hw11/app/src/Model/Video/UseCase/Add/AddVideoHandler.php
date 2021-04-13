<?php

declare(strict_types=1);

namespace App\Model\Video\UseCase\Add;

use App\Model\Video\Entity\Video;
use App\Model\Video\Exception\VideoAlreadyExistsException;
use App\Model\Video\Repository\VideoRepositoryInterface;

class AddVideoHandler
{

    private VideoRepositoryInterface $videoRepository;

    public function __construct(VideoRepositoryInterface $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function handle(AddVideoCommand $command): void
    {
        $video = $this->buildVideo($command);

        $this->throwExceptionIfAlreadyExists($video);

        $this->videoRepository->add($video);
    }

    private function throwExceptionIfAlreadyExists(Video $video): void
    {
        if ($this->videoRepository->hasById($video->getId())) {
            throw new VideoAlreadyExistsException('Видео уже добавлено');
        }
    }

    private function buildVideo(AddVideoCommand $command): Video
    {
        $video = new Video($command->id, $command->title, $command->channelId);

        $video->changeLikeCount($command->likeCount);
        $video->changeDislikeCount($command->dislikeCount);

        return $video;
    }

}