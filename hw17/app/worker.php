<?php
require_once "config.php";

use Jekys\YoutubeAPI;

$api = new YoutubeAPI(
    $config->youtube_app_name,
    $config->youtube_scopes,
    $config->youtube_json
);

while (true) {
    $channelId = $queue->getMessage();
    if (!empty($channelId)) {
        $channelData = $api->getChannelById($channelId);
        $channelData['videos'] = $api->getChannelVideos($channelId);
        $stats->insertData($channelData);
    } else {
        sleep(10);
    }
}
