<?php

require 'vendor/autoload.php';

use app\YoutubeFetch;
use app\Channel\Mapper as ChannelMapper;

$params = include 'config/main.php';

/**
$googleClient = new Google_Client([
    'application_name' => $params['application_name'],
    'developer_key' => $params['youtube_api_key']
]);

$youtubeFetch = new YoutubeFetch(new Google_Service_YouTube($googleClient));

$myChannel = 'UCjKj8QmMJNJThLchHs56Sww';
$keyAndPeele = 'UCdN4aXTrHAtfgbVG9HjBmxQ';
$ronMinis = 'UCSsywI9eO-IXyjOFZxp8JmA';

$channel = $youtubeFetch->fetchChannelWithVideos($keyAndPeele);
 * */

$channelMapper = new ChannelMapper(new \app\Storage\MongoDb($params['mongodb']));

$result = $channelMapper->getTopChannels(1);

var_dump($result); exit;

//$channelMapper->insertChannel($channel);




