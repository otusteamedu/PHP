<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use App\Application;

try
{
    $app = new Application();
    $channelUrl = $app->request->get('channel_url') ?: 'channel_1_url' ;
    $result = $app->stat->sumAllChannelLikes($channelUrl);

    $app->response->send($result);
}
catch (\Throwable $e)
{
   echo $e->getMessage();
}
