<?php
require_once __DIR__ . '/YouTubeApi.php';
require_once __DIR__ . '/Statistic.php';

if(count($argv) < 2) {
    echo "Введите id канала!";
    die;
}

$idChannel = $argv[1];

$static = new Statistic();

var_dump($static->addChannel(new YouTubeApi(), $idChannel));
//var_dump($static->deleteChannel('ФАЛТ МФТИ'));