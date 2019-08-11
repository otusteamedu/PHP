<?php

require '../vendor/autoload.php';

use hw16\models\YoutubeVideoBuilder;
use hw16\models\YoutubeChannelBuilder;
use hw16\Analyzer;
use MongoDB\Client;

$youtubeVideo = (new YoutubeVideoBuilder())
    ->setChannel(1)
    ->build();

$client = new Client('mongodb://127.0.0.1/');
$db = $client->selectDatabase('youtube');
$channelCollection = $db->selectCollection('channel');
$videoCollection = $db->selectCollection('video');

$channelsId = array();

for ($i = 0; $i < 10; $i++) {
    $channel = (new YoutubeChannelBuilder())
        ->setName('NAME:' . uniqid())
        ->setDescription('DESCRIPTION:' . uniqid())
        ->setSubscribers(rand(0, 100000))
        ->build();
    $insertOneChannel = $channelCollection->insertOne([
        'name' => $channel->name,
        'description' => $channel->description,
        'subscribers' => $channel->subscribers,
    ]);

    $channelsId[] = $insertOneChannel->getInsertedId();
}

$videos = array();

foreach ($channelsId as $channelId) {
    for ($j = 0; $j < 10; $j++) {
        $video = (new YoutubeVideoBuilder())
            ->setChannel($channelId)
            ->setName('NAME:'.uniqid())
            ->setViews(rand(0, 10000))
            ->setLikes(rand(0, 10000))
            ->setDislikes(rand(0, 10000))
            ->build();

        $videos[] = $video;
    }
}

$videoCollection->insertMany($videos);

$analyzer = new Analyzer($videoCollection);

//LIKES
$analyzer->getCountChannelLikes($channelsId[rand(0, count($channelsId) - 1)]);

//DISLIKES
$analyzer->getCountChannelDislikes($channelsId[rand(0, count($channelsId) - 1)]);

//CHANNELS ANALYZE
foreach ($analyzer->getTopChannels() as $channel) {
    echo "{$channel['name']} - rating: {$channel['rating']}, likes: {$channel['likes']}, dislikes: {$channel['dislikes']}\n";
}