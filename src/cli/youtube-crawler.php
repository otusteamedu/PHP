<?php

use Core\AppConfig;
use Task\YoutubeCrawlerController;

require_once __DIR__ . "/../vendor/autoload.php";

$appConf = new AppConfig(getenv());

$channelsIdList = explode(",", $argv[1] ?? "");

foreach ($channelsIdList as $channelId) {
    $task = new YoutubeCrawlerController($appConf);
    $task->setChannelId($channelId)->run();
}