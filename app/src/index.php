<?php

include_once __DIR__ . '/../vendor/autoload.php';

use App\Entity\Channel;
use App\MongoRepository;

$channel = new Channel();
$channel->setTitle('xxx');
$channel->setUrl('http://');

$channelRepository = new MongoRepository('channel');
$channelRepository->insert($channel);
