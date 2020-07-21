<?php

namespace App\Controllers;

use Classes\Repositories\YoutubeVideoRepository;
use Classes\Repositories\YoutubeRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class YoutubeChannelController
{
    private $youtubeChannelService;

    public function __construct(\YoutubeService $youtubeChannelService)
    {
       $this->youtubeChannelService = $youtubeChannelService;
    }

    public function createChannel()
    {

        $test = 1;
    }

    public function deleteChannel()
    {
        $test = 1;
    }
}
