<?php


require_once __DIR__ . '/Statistic.php';

$static = new Statistic();

//var_dump($static->addChannel(new YouTubeApi(), 'UCetgtvy93o3i3CvyGXKFU3g'));
//var_dump($static->deleteChannel('ФАЛТ МФТИ'));

$objects = $static->getViews();

include __DIR__ . "/view.php";





