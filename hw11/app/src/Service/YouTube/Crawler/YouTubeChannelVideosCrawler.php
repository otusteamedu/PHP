<?php

declare(strict_types=1);

namespace App\Service\YouTube\Crawler;

use App\Model\Video\Exception\VideoAlreadyExistsException;
use App\Model\Video\UseCase\Add\AddVideoCommand;
use App\Model\Video\UseCase\Add\AddVideoHandler;
use App\Model\Video\UseCase\Update\UpdateVideoCommand;
use App\Model\Video\UseCase\Update\UpdateVideoHandler;
use App\Service\YouTube\Dto\VideoDto;
use App\Service\YouTube\YouTubeClient;

class YouTubeChannelVideosCrawler
{

    private YouTubeClient      $youTubeClient;
    private AddVideoHandler    $addVideoHandler;
    private UpdateVideoHandler $updateVideoHandler;

    public function __construct(
        YouTubeClient $youTubeClient,
        AddVideoHandler $addVideoHandler,
        UpdateVideoHandler $updateVideoHandler
    ) {
        $this->youTubeClient = $youTubeClient;
        $this->addVideoHandler = $addVideoHandler;
        $this->updateVideoHandler = $updateVideoHandler;
    }

    public function craw(string $channelId): void
    {
        $videoDTOs = $this->youTubeClient->getVideos($channelId);

        foreach ($videoDTOs as $videoDto) {
            try {
                $this->addVideo($videoDto);
            } catch (VideoAlreadyExistsException $e) {
                $this->updateVideo($videoDto);
            }
        }
    }

    private function addVideo(VideoDto $videoDto): void
    {
        $command = new AddVideoCommand($videoDto->id, $videoDto->title, $videoDto->channelId);
        $command->likeCount = $videoDto->likeCount;
        $command->dislikeCount = $videoDto->dislikeCount;

        $this->addVideoHandler->handle($command);
    }

    private function updateVideo(VideoDto $videoDto): void
    {
        $command = new UpdateVideoCommand($videoDto->id, $videoDto->title);
        $command->likeCount = $videoDto->likeCount;
        $command->dislikeCount = $videoDto->dislikeCount;

        $this->updateVideoHandler->handle($command);
    }

}