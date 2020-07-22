<?php

namespace Services;

use Classes\Dto\ChannelDto;

interface YoutubeChannelServiceInterface
{
    public function create(ChannelDto $channelDto);

    public function deleteById(string $id);
}
