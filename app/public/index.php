<?php
require_once '../bootstrap/bootstrap.php';

use VideoPlatform\DB\ElasticSearch;
use VideoPlatform\platforms\Youtube;
use VideoPlatform\VideoPlatform;

//TODO: $app = new App();
// $app->run();
// channel info https://youtube.googleapis.com/youtube/v3/channels?part=snippet%2CcontentDetails%2Cstatistics&forUsername=wylsacom&key=AIzaSyB2QWhtagXGmcfmVoCzAHmUwc0yXtYlix0

//id = UCt7sv-NKh44rHAEb-qCCxvA

//https://www.googleapis.com/youtube/v3/search?key=AIzaSyB2QWhtagXGmcfmVoCzAHmUwc0yXtYlix0&channelId=UCt7sv-NKh44rHAEb-qCCxvA&part=snippet,id&order=date&maxResults=20
try {
    $videoPlatform = new Youtube();
    $db = new ElasticSearch();

    $app = new VideoPlatform($videoPlatform, $db);
} catch (\Exception $e) {
    echo $e->getMessage();
}

