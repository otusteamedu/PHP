<?php

declare(strict_types=1);

use App\Contracts\IO\{Input, Output};
use App\Contracts\Storage;
use App\Services\YouTubeStatistics;

$container = require dirname(__FILE__) . '/config/container.php';

/** @var Output $output */
$output = $container[Output::class];

$statistics = new YouTubeStatistics(
    $container[Storage::class],
    $container[Output::class],
    $container[Input::class]
);

$channel = $statistics->selectChannel();

if ($channel === null) {
    exit();
}

$channelStatistics = $statistics->getStatisticsOfChannelVideos($channel->getId());

$output->writeLn("Channel statistics (by all videos):");
$output->writeLn("\tLikes: {$channelStatistics['statistics']['likes']}");
$output->writeLn("\tDislikes: {$channelStatistics['statistics']['dislikes']}");
$output->writeLn('-------------------');

$topChannels = $statistics->getTopChannels();

$output->writeLn("Top channels:");
foreach ($topChannels as $key => $item) {
    $output->writeLn("\t" . ($key + 1) . ". {$item['channel']['title']}");
}
