<?php
require_once 'vendor/autoload.php';
require_once 'MongoStorage.php';

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

$mongoStorage = new MongoStorage();
var_dump($mongoStorage->addChannel($channel1));
var_dump($mongoStorage->addChannel($channel2));