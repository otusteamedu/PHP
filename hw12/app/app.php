<?php
/**
* @author E.Prokhorov <prohorov-evgen@ya.ru>
*
* This scipt is a part of YouTube Channels Statistics project
*
* Here you can find some usage examples
*
*/
require_once $_SERVER['APP_PATH'].'/config.php';

$topChannels = $stats->getTopChannels(3);
var_dump($topChannels);

$channelStats = $stats->getByChannel(current($topChannels)['channel_id']);
var_dump($channelStats);
