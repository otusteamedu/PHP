<?php

namespace Classes\Repositories;

use Classes\Models\YoutubeChannel;

interface YoutubeChannelRepositoryInterface
{
    public function create(YoutubeChannel $youtubeChannelModel);

    public function deleteById(string $id);

    public function getById(string $id);

    public function getAll();

    public function getChannelVideosById(string $channelId);
}
