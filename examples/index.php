<?php

require '../vendor/autoload.php';

$adapter = new \crazydope\youtube\db\adapter\MongoAdapter('mongodb://127.0.0.1','otus');

$channelStorage = new \crazydope\youtube\db\ChannelStorage($adapter, 'channel');
$videoStorage = new \crazydope\youtube\db\VideoStorage($adapter, 'video');

$factory = new \crazydope\youtube\Factory();

$channel1 = $factory->buildChannel('First Channel', 'https://www.youtube.com/channel/1');
$channel1->setId($channelStorage->insertOne($channel1)->getInsertedId());

$channel2 = $factory->buildChannel('Second Channel', 'https://www.youtube.com/channel/2');
$channel2->setId($channelStorage->insertOne($channel2)->getInsertedId());

$channel3 = $factory->buildChannel('Third Channel', 'https://www.youtube.com/channel/3');
$channel3->setId($channelStorage->insertOne($channel3)->getInsertedId());

$videos = [];

$videos[] = $factory->buildVideo($channel1->getId(), 'first video','https://www.youtube.com/watch?v=SyY',10,2)->toArray();
$videos[] = $factory->buildVideo($channel1->getId(), 'second video','https://www.youtube.com/watch?v=SyY123',30,15)->toArray();
$videos[] = $factory->buildVideo($channel1->getId(), 'third video','https://www.youtube.com/watch?v=SyY31',20,25)->toArray();

$videos[] = $factory->buildVideo($channel2->getId(), 'fourth video','https://www.youtube.com/watch?v=SyY521',1,2)->toArray();
$videos[] = $factory->buildVideo($channel2->getId(), 'fifth video','https://www.youtube.com/watch?v=SyYSd1',45,23)->toArray();
$videos[] = $factory->buildVideo($channel2->getId(), 'sixth video','https://www.youtube.com/watch?v=SyYFds',11,8)->toArray();

$videos[] = $factory->buildVideo($channel3->getId(), 'seventh video','https://www.youtube.com/watch?v=SyY521',21,0)->toArray();
$videos[] = $factory->buildVideo($channel3->getId(), 'eighth video','https://www.youtube.com/watch?v=SyYSd1',55,3)->toArray();
$videos[] = $factory->buildVideo($channel3->getId(), 'ninth video','https://www.youtube.com/watch?v=SyYFds',0,88)->toArray();

$result = $videoStorage->insertMany($videos);

// STAT

//channel stat
echo $videoStorage->getChannelVideoStats($channel1). PHP_EOL;
// top rate
$list = $videoStorage->getTopRatedChannels($channelStorage);
foreach ($list as $stat){
    echo $stat. PHP_EOL;
}

