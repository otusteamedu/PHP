<?php
/**
* @author E.Prokhorov <prohorov-evgen@ya.ru>
*
* This scipt is a part of YouTube Channels Statistics project
*
* Helps to import data from Youtube API to the Mongo database
*
* NOTE: don't forget to make JSON credentials file for Youtube API in the Google Developer Console
*/

if (php_sapi_name() != 'cli') {
    die('Sorry! This script works only via CLI'.PHP_EOL);
}

require_once $_SERVER['APP_PATH'].'/config.php';

$secretJson = 'secret.json';

if (!file_exists($secretJson)) {
    die('Sorry! File ".'.$secretJson.'." doesn`t exists.'.PHP_EOL);
}

$api = new Jekys\YoutubeAPI($secretJson);

$region = readline('Enter the region code [ru]: ');

if (empty($region)) {
    $region = 'ru';
}

$categories = $api->getCategoriesByRegion($region);

echo 'Region catrgories:'.PHP_EOL;

foreach ($categories as $id => $category) {
    echo '['.$id.'] '.$category['title'].PHP_EOL;
}

$categoryId = false;

while (!$categoryId) {
    $choosenCategory = readline('Enter the category number: ');

    if ($choosenCategory === '' || !array_key_exists($choosenCategory, $categories)) {
        echo 'Error: wrong category number'.PHP_EOL;
    } else {
        $categoryId = $categories[$choosenCategory]['id'];
    }
}

$channels = $api->getChannelsByCatergory($categoryId);

foreach ($channels as $channelId => $channelData) {
    $videos = $api->getChannelVideos($channelId);
    $channelData['videos'] = $videos;

    $stats->insertData($channelData);
}

echo 'Done'.PHP_EOL;
