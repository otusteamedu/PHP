<?php
require_once 'vendor/autoload.php';

$fetcher = new App\YouTubeInfoFetcher();
$channel = new App\ChannelsModel();

$channelNames = ['woffachannel', 'BellatorMMA', 'M1GlobalRussia', 'UFC'];
foreach ($channelNames as $channelName) {

    $channelInfo = $fetcher->getChannelInfoByName($channelName);

    $channel->setName($channelInfo->items[0]->snippet->title);
    $channel->setDescription($channelInfo->items[0]->snippet->description);

    $videos = [];
    $channelVideos = $fetcher->getVideosInfoByChannelId($channelInfo->items[0]->id);
    foreach ($channelVideos->items as $channelVideo) {
        $videoStats = $fetcher->getVideosStatisticsById($channelVideo->id->videoId);
        $videos[] = [
            'name' => $channelVideo->snippet->title,
            'likes' => $videoStats->items[0]->statistics->likeCount,
            'dislikes' => $videoStats->items[0]->statistics->dislikeCount
        ];
    }
    $channel->setVideos($videos);
    $channel->save();
}
print_r($channel->getAllData());
print_r($channel->getTopChannelsStatistics(3));


