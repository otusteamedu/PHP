<?php

namespace Services;

use Classes\Dto\ChannelDto;
use Classes\Models\YoutubeChannel;
use Classes\Repositories\YoutubeChannelRepositoryImpl;

class YoutubeChannelServiceImpl implements YoutubeChannelServiceInterface
{
    private $youtubeChannelRepository;

    public function __construct(YoutubeChannelRepositoryImpl $youtubeChannelRepository)
    {
        $this->youtubeChannelRepository = $youtubeChannelRepository;
        $test = 1;
    }

    public function create(ChannelDto $channelDto)
    {
        $model = new YoutubeChannel();
        $model->id = $channelDto->channelId;
        $model->name = $channelDto->channelName;
        $model->videoIds = $channelDto->channelVideoIds;


        $this->youtubeChannelRepository->create($model);
    }

    public function deleteById(string $id)
    {
        $this->youtubeChannelRepository->deleteById($id);
    }
}
