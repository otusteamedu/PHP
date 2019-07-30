<?php
/**
* @author E.Prokhorov <prohorov-evgen@ya.ru>
*
* This scipt is a part of YouTube Channels Statistics project
*
* Helps to import test data from file to the mongo database
*/

if (php_sapi_name() != 'cli') {
    die('Sorry! This script works only via CLI'.PHP_EOL);
}

require_once $_SERVER['APP_PATH'].'/config.php';

$json = file_get_contents('channels.json');
$channels = json_decode($json, true);

foreach ($channels as $channel) {
    $stats->insertData($channel);
}

echo 'Done'.PHP_EOL;
