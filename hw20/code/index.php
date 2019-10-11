<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

require_once __DIR__ . "/vendor/autoload.php";

use APP\YouTubeInfo\YouTubeInfoFetcher;
use APP\ChannelStorage;
use APP\YouTubeInfo\YouTubeChannelStatistics;

$userNames = ["Filme", "wwwCOASTERFORCEcom", "AcademyOriginals", "Urgantshow", "voxdotcom"];

$fetcher = new YouTubeInfoFetcher();
$storage = new ChannelStorage();

foreach ($userNames as $userName) {
    $fetcher->setUserName($userName);
    $channelInfo = $fetcher->getChannelInfo();
    $storage->addChannel($channelInfo->getByVideoInfo());
}

$stats = new YouTubeChannelStatistics();
$top5 = $stats->getTopChannels(5);

foreach ($top5 as $channel => $rate) {
    echo "Like/dislike rate for $channel is $rate" . PHP_EOL;
}