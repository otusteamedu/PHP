<?php
require_once 'vendor/autoload.php';
require_once 'MongoStorage.php';
require_once 'Statistics.php';

$channel1 = [
    'channelName' => 'otus',
    'films' => [
        [
            'filmName' => 'Пила',
            'likes' => 20,
            'dislike' => 10,
        ],
        [
            'filmName' => 'Лунтик',
            'likes' => 100,
            'dislike' => 2,
        ],
    ],
];

$channel2 = [
    'channelName' => 'otus2',
    'films' => [
        [
            'filmName' => 'Пила2',
            'likes' => 10,
            'dislike' => 20,
        ],
        [
            'filmName' => 'Лунтик2',
            'likes' => 50,
            'dislike' => 80,
        ],
        [
            'filmName' => 'Крик',
            'likes' => 500,
            'dislike' => 99,
        ],
    ],
];

$youtubeStorage = new MongoStorage('mongodb://mongodb', 'youtube', 'channels');
$youtubeStatistics = new Statistics($youtubeStorage);
var_dump($youtubeStatistics->getTopChannels(5));exit;
$r = 0;
foreach ($youtubeStorage->getChannels() as $v)
{
    echo $v['channelName'];exit;
    //var_dump(json_decode(json_encode($v), true));
    foreach ($v['films'] as $film) {
        $r += $film['likes'];
    }
    //var_dump($v['films'][0]["likes"]);
    //echo "____________";
    echo $r . PHP_EOL;
}
echo $r . PHP_EOL;
exit;
var_dump($youtubeStorage->getChannels(['channelName' => 'otus']));exit;
var_dump($youtubeStorage->addChannel($channel1));
var_dump($youtubeStorage->addChannel($channel2));
