<?php

namespace App\Commands;

use App\Config\Config;
use App\Grabbers\YoutubeGrabber;

class GrabCommand implements Command
{
    public function execute (): string
    {
        $channelsList = Config::getInstance()->getItem('channels_for_grabbing_list');

        (new YoutubeGrabber())->grab($channelsList);

        return json_encode(['finished' => true]);
    }
}