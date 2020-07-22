<?php

namespace App\Providers;

use Slim\App;

class RouteProvider
{
    public function register(App $app): void
    {
        //youtube
        $app->post('/video/create', 'App\Controllers\YoutubeVideoCrudController:createVideo');
        $app->post('/video/delete', 'App\Controllers\YoutubeVideoCrudController:deleteVideoById');
        $app->post('/channel/create', 'App\Controllers\YoutubeChannelCrudController:createChannel');
        $app->post('/channel/delete', 'App\Controllers\YoutubeChannelCrudController:deleteChannelById');

        $app->get('/channels/video-rating/{channelId}/{limit}', 'App\Controllers\YoutubeChannelStatisticController:TotalChannelVideosLikesNumber');
        $app->get('/channels/top/{limit}', 'App\Controllers\YoutubeChannelStatisticController:TopChannelsVideosLikesDislikesRating');

        //Events
        $app->post('/event/create', 'App\Controllers\EventCrudController:create');
        $app->post('/event/delete', 'App\Controllers\EventCrudController:delete');
        $app->post('/event/priority', 'App\Controllers\EventController:getPriority');
    }
}
