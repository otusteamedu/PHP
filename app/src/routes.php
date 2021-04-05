<?php


use App\Controllers\EventController;
use App\Controllers\HomeController;
use App\Controllers\ChannelParseController;
use App\Controllers\ChannelController;
use App\Controllers\VideoController;
use App\Core\Request;

return [
    Request::GET_METHOD => [
        '/' => [HomeController::class, 'index'],
        '/channels/parse' => [ChannelParseController::class, 'index'],
        '/channels' => [ChannelController::class, 'index'],
        '/channels/search' => [ChannelController::class, 'search'],
        '/videos' => [VideoController::class, 'index'],
        '/events/create' => [EventController::class, 'create'],
        '/events/search' => [EventController::class, 'search'],
        '/events/flush' => [EventController::class, 'flush'],
        '/events' => [EventController::class, 'index'],
    ],
    Request::POST_METHOD => [
        '/channels/parse' => [ChannelParseController::class, 'store'],
        '/events' => [EventController::class, 'store'],
    ]
];