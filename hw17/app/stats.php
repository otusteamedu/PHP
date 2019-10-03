<?php
require_once "config.php";

$topChannels = $stats->getTopChannels(3);
var_dump($topChannels);

$channelStats = $stats->getByChannel(current($topChannels)['channel_id']);
var_dump($channelStats);
