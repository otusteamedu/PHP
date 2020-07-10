<?php

$channelModel = new \YoutubeApp\ChannelsModel();
$channelStatistic = new \YoutubeApp\ChannelsStatistic();

print_r($channelStatistic->getTopChannelsStatistics(3));
print_r($channelModel->getAllData());
