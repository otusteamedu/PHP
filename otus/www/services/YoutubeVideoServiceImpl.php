<?php

namespace Services;

use Classes\Dto\VideoDto;
use Classes\Repositories\YoutubeVideoRepository;
use Slim\Psr7\Request;

class YoutubeVideoServiceImpl implements YoutubeVideoServiceInterface
{
    private $youtubeVideoRepository;

    public function __construct(YoutubeVideoRepository $youtubeVideoRepository)
    {
        $this->youtubeVideoRepository = $youtubeVideoRepository;
        $test = 1;
    }


    public function create(VideoDto $videoDto)
    {
       $this->youtubeVideoRepository->create();
    }

    public function delete(string $id)
    {
        $this->youtubeVideoRepository->delete();
    }
}
