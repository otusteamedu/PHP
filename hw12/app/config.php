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

$stats = new Jekys\Statistics($mongoHost, $mongoPort, $mongoDb);
