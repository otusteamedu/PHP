<?php

namespace Services;

use Classes\Dto\ChannelDto;
use Classes\Repositories\YoutubeChannelRepository;

class YoutubeChannelServiceImpl implements YoutubeChannelServiceInterface
{
    private $youtubeChannelRepository;

    public function __construct(YoutubeChannelRepository $youtubeChannelRepository)
    {
        $this->youtubeChannelRepository = $youtubeChannelRepository;
        $test = 1;
    }

    public function create(ChannelDto $channelDto)
    {
        $this->youtubeChannelRepository->create();
    }

    public function delete(string $id)
    {
        $this->youtubeChannelRepository->deleteById();
    }
}
