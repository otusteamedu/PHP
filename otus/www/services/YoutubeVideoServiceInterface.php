<?php

namespace Services;

use Classes\Dto\VideoDto;

interface YoutubeVideoServiceInterface
{
    public function create(VideoDto $videoDto);

    public function deleteById(string $id);
}
