<?php

require "vendor/autoload.php";

use API\YoutubeVideo;
use Models\Task;
use Controllers\DataBaseControllers\MongoDBConnection;
use \Controllers\YoutubeController;
use \Controllers\YoutubeStatisticsController;


$client = new Google_Client();
$video = new YoutubeVideo($client);
$channelID = 'UC-KtZ9AOGkyhAojdFeoYJLQ';
$channelVideoList = $video->getInfoChannelVideoInfo($channelID);


$model = new Task();
$model->setData($channelVideoList);


$mongo = MongoDBConnection::connectMongo();
$youtube = new YoutubeController($mongo);
$youtube->store($model);

$getChannelVideosFullInfo = $youtube->all();

$statistics = new YoutubeStatisticsController($mongo);
$likes = $statistics->getChannelLikes($channelID);
$dislikes = $statistics->getChannelDislikes($channelID);
$likeDiff = $statistics->getChannelLikeDifference($channelID);
$mostPopular = $statistics->getMostRatingChannels(3);

print_r($likes);
print_r($dislikes);
print_r($likeDiff);
print_r($mostPopular);


