<?php


use App\Services\YouTubeChannels;


return [
    YouTubeChannels::class => function () {
        return new YouTubeChannels();
    }
];
