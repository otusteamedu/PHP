<?php
/**
* @author E.Prokhorov <prohorov-evgen@ya.ru>
*
* This scipt is a part of YouTube Channels Statistics project
*
* Configuration file stores any variables for other scripts in the project
*
*/
require_once $_SERVER['APP_PATH'].'/vendor/autoload.php';

$mongoHost = $_SERVER['MONGO_HOST'];
$mongoPort = $_SERVER['MONGO_PORT'];
$mongoDb = $_SERVER['MONGO_DB'];
$mongoCollection = $_SERVER['MONGO_COLLECTION'];

$youtubeAppName = 'Youtube Channels Stats';
$youtubeJson = $_SERVER['APP_PATH'].'/import/secret.json';
$youtubeScopes = [
    'https://www.googleapis.com/auth/youtube.readonly',
];

$stats = new Jekys\Statistics($mongoHost, $mongoPort, $mongoDb, $mongoCollection);
