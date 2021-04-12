<?php

declare(strict_types=1);

namespace App\Service\YouTube\Crawler;

use App\Model\Channel\Exception\ChannelAlreadyExistsException;
use App\Model\Channel\UseCase\Add\AddChannelCommand;
use App\Model\Channel\UseCase\Add\AddChannelHandler;
use App\Model\Channel\UseCase\Update\UpdateChannelCommand;
use App\Model\Channel\UseCase\Update\UpdateChannelHandler;
use App\Service\YouTube\Dto\ChannelDto;
use App\Service\YouTube\YouTubeClient;

class YouTubeChannelCrawler
{

    private YouTubeClient        $youTubeClient;
    private AddChannelHandler    $addChannelHandler;
    private UpdateChannelHandler $updateChannelHandler;

    public function __construct(
        YouTubeClient $youTubeClient,
        AddChannelHandler $addChannelHandler,
        UpdateChannelHandler $updateChannelHandler
    ) {
        $this->youTubeClient = $youTubeClient;
        $this->addChannelHandler = $addChannelHandler;
        $this->updateChannelHandler = $updateChannelHandler;
    }

    public function craw(string $channelId): void
    {
        $channelDto = $this->youTubeClient->getChannelById($channelId);

        try {
            $this->addChannel($channelDto);
        } catch (ChannelAlreadyExistsException $e) {
            $this->updateChannel($channelDto);
        }
    }

    private function addChannel(ChannelDto $channelDto): void
    {
        $command = new AddChannelCommand($channelDto->id, $channelDto->title);

        $this->addChannelHandler->handle($command);
    }

    private function updateChannel(ChannelDto $channelDto): void
    {
        $command = new UpdateChannelCommand($channelDto->id, $channelDto->title);

        $this->updateChannelHandler->handle($command);
    }

}