<?php
require_once "config.php";

$channelId = readline('Enter YouTube channel ID: ');
$queue->sendMessage($channelId);

echo  "Channel has been added to the queue".PHP_EOL;
