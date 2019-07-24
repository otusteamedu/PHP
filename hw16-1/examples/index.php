<?php

require_once '../vendor/autoload.php';

// db connection
$client = new \MongoDB\Client('mongodb://192.168.56.101/');
$db = $client->selectDatabase('youtube');
$channelCollection = $db->selectCollection('channel');
$videoCollection = $db->selectCollection('video');

// clean old
$channelCollection->drop();
$videoCollection->drop();

// factory (channels and videos)
$factory = new \TimGa\Youtube\Factory();

// create channels
$channel1 = $factory->createChannel('cName1', 'cDescription1', 'cAuthor1');
$channel2 = $factory->createChannel('cName2', 'cDescription2', 'cAuthor2');
$channel3 = $factory->createChannel('cName3', 'cDescription3', 'cAuthor3');

// insert channels into mongodb
$channelCollection->insertOne($channel1);
$channelCollection->insertOne($channel2);
$channelCollection->insertOne($channel3);

// create videos
$videos[] = $factory->createVideo($channel1->getName(), 'vName11', 23, 2);
$videos[] = $factory->createVideo($channel1->getName(), 'vName12', 35, 8);
$videos[] = $factory->createVideo($channel1->getName(), 'vName13', 72, 12);
$videos[] = $factory->createVideo($channel2->getName(), 'vName21', 243, 27);
$videos[] = $factory->createVideo($channel2->getName(), 'vName22', 2, 85);
$videos[] = $factory->createVideo($channel2->getName(), 'vName23', 63, 34);
$videos[] = $factory->createVideo($channel3->getName(), 'vName31', 326, 71);
$videos[] = $factory->createVideo($channel3->getName(), 'vName32', 45, 543);
$videos[] = $factory->createVideo($channel3->getName(), 'vName33', 433, 41);

// insert videos into mongodb
$videoCollection->insertMany($videos);

// statistics
$statistics = new \TimGa\Youtube\Statistics($videoCollection);

// sum likes/dislikes per channel
$statistics->getLikesCountForChannel($channel1->getName());  // returns 130
$statistics->getDislikesCountForChannel($channel1->getName());  // returns 22

// get top channels with ratio = (likes/dislikes)
foreach ($statistics->getTopChannels() as $top) {
    printf("Channel %s has rating %f (likes: %d, dislikes: %d)\n", $top['channelName'], $top['ratio'], $top['likesCount'], $top['dislikesCount']);
}
