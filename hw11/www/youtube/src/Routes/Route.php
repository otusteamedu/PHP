<?php

namespace App\Routes;

use App\Controllers\EventController;
use App\Controllers\YoutubeController;
use Klein\Klein;

class Route
{
    /**
     * @var Klein
     */
    private Klein $router;

    /**
     * Route constructor.
     */
    public function __construct()
    {
        $this->router = new Klein();
    }

    public function init(): void
    {
        $this->router->respond('GET', '/spider', static function () {
            return (new YoutubeController())->spider();
        });
        $this->router->respond('GET', '/statistics-channel-videos', static function ($request) {
            return (new YoutubeController)->getStatisticsChannelVideos();
        });
        $this->router->respond('GET', '/get-top-channels', static function ($request) {
            return (new YoutubeController)->getTopChannels($request);
        });
        $this->router->respond('DELETE', '/channels', static function () {
            return (new YoutubeController)->deleteChannels();
        });

        $this->router->dispatch();
    }
}