<?php

include_once __DIR__ . '/../vendor/autoload.php';

use App\Entity\Channel;
use App\Entity\Video;
use App\MongoRepository;
use App\Stat;

$channelRepository = new MongoRepository('channel');
$videoRepository = new MongoRepository('video');

//////////////////////////////////////////

$channel1 = new Channel();
$channel1->setId(1);
$channel1->setTitle('Channel #1');
$channel1->setUrl('https://www.youtube.com/channel/1');
$channelRepository->insert($channel1->toArray());

$video1 = new Video();
$video1->setId(1);
$video1->setUrl('https://www.youtube.com/watch?v=1');
$video1->setTitle('Video #1');
$video1->setLikeCount(30);
$video1->setDislikeCount(10);
$video1->setChannelId(1);
$videoRepository->insert($video1->toArray());

$video2 = new Video();
$video2->setId(2);
$video2->setUrl('https://www.youtube.com/watch?v=2');
$video2->setTitle('Video #2');
$video2->setLikeCount(50);
$video2->setDislikeCount(20);
$video2->setChannelId(1);
$videoRepository->insert($video2->toArray());

//////////////////////////////////////////

$channel2 = new Channel();
$channel2->setId(2);
$channel2->setTitle('Channel #2');
$channel2->setUrl('https://www.youtube.com/channel/2');
$channelRepository->insert($channel2->toArray());

$video3 = new Video();
$video3->setId(3);
$video3->setUrl('https://www.youtube.com/watch?v=3');
$video3->setTitle('Video #3');
$video3->setLikeCount(100);
$video3->setDislikeCount(1000);
$video3->setChannelId(2);
$videoRepository->insert($video3->toArray());

$video4 = new Video();
$video4->setId(4);
$video4->setUrl('https://www.youtube.com/watch?v=4');
$video4->setTitle('Video #4');
$video4->setLikeCount(10);
$video4->setDislikeCount(1);
$video4->setChannelId(2);
$videoRepository->insert($video4->toArray());

//////////////////////////////////////////

$stat = new Stat($channelRepository, $videoRepository);
echo 'Total channel #1 likes: ' . $stat->getChannelTotalLikeCount('1') . PHP_EOL;
echo 'Total channel #1 dislikes: ' . $stat->getChannelTotalDislikeCount('1') . PHP_EOL;
echo 'Top channels by rate like/dislike: ' . PHP_EOL;
foreach ($stat->getTopChannels() as $ch) {
    echo $ch['title'] . ' with rate: ' . $ch['rate'] . PHP_EOL;
}
