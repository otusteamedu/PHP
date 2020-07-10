<?php


use YoutubeApp\AddDataToCollectionModel;
use YoutubeApp\YoutubeGetInfoModel;

$youtubeModel = new YoutubeGetInfoModel();
$addDoc = new AddDataToCollectionModel();

$channelNames = ['KuTstupid', 'CentralPartnership', 'ctctv', 'fixiki', 'KanalDisneyCartoons'];
foreach ($channelNames as $channelName) {

    $channelInfo = $youtubeModel->getChannelInfoByName($channelName);

    $addDoc->setNameField($channelInfo->items[0]->snippet->title);
    $addDoc->setDescriptionField($channelInfo->items[0]->snippet->description);

    $videos = [];
    $channelVideos = $youtubeModel->getVideosInfoByChannelId($channelInfo->items[0]->id);
    foreach ($channelVideos->items as $channelVideo) {
        $videoStats = $youtubeModel->getVideosStatisticsById($channelVideo->id->videoId);
        $videos[] = [
            'name' => $channelVideo->snippet->title,
            'likes' => $videoStats->items[0]->statistics->likeCount,
            'dislikes' => $videoStats->items[0]->statistics->dislikeCount
        ];
    }
    $addDoc->setVideosField($videos);
    $addDoc->addDocument();
}

