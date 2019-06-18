#!/usr/bin/env php

<?php

define('APP_DIR', __DIR__ );
require APP_DIR . '/vendor/autoload.php';

use Otus\{YouTubeApi, Channel, BaseRecord};
//
//$connection = new \MongoDB\Client();
//$collection = $connection->selectCollection('myapp', 'channel');
//$var = $collection->findOne(['_id'=>'UCiVZttFkdEwMi3QXpRqFTzQ']);
//die(var_dump((array)$var));
$config = parse_ini_file(APP_DIR . '/config.ini', true);

BaseRecord::$connection = new MongoDB\Client();
BaseRecord::$database = 'myapp';
//$channel = new Channel(['id'=>13, 'title'=>'title13']);
//$channel->setTitle(13);
//die(var_dump($channel));
//$channel->save();
//$connection = new \MongoDB\Client();
//$collection = $connection->selectCollection('myapp', 'channel');
//$var = $collection->find();
//foreach ($var as $doc) {
//    (var_dump($doc));
//}
//die();
//die(var_dump($channel));
$api = YouTubeApi::getInstance();
$channel = $api->getChannelInfoById('UCiVZttFkdEwMi3QXpRqFTzQ');
if ($channel) {
    $record = new Channel();
    $record->fromYouTubeData($channel);
    $record->save();
    die(var_dump($api->getVideosFromPlaylist($record->getUploads())));
}



    die(var_dump($api->getChannelInfoById('UCiVZttFkdEwMi3QXpRqFTzQ')));

//$url = '
//  https://www.googleapis.com/youtube/v3/
//  channels?
//  part=snippet%2CcontentDetails%2Cstatistics&
//  id=UCiVZttFkdEwMi3QXpRqFTzQ&
//  key=$key';

$file = file_get_contents("https://www.googleapis.com/youtube/v3/channels?part=snippet%2CcontentDetails%2Cstatistics&id=UCiVZttFkdEwMi3QXpRqFTzQ&key=$key");
//var_dump($file);
//die();
$data = json_decode($file);
$playList = $data->items[0]->contentDetails->relatedPlaylists->uploads;
$playListUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=$playList&key=$key";
$resp = json_decode(file_get_contents($playListUrl));
foreach ($resp->items as $file) {
    $id = $file->snippet->resourceId->videoId;
//    die(var_dump($file, $id));
    $videoUrl = "https://www.googleapis.com/youtube/v3/videos?part=snippet%2Cstatistics&id=$id&key=$key";
    die(var_dump((file_get_contents($videoUrl))));
}
die(var_dump($resp));

