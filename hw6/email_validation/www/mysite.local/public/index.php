<?php

require_once __DIR__.'/../vendor/autoload.php';

$emailsList = [
    'test@test.ru',
    '123@yandex.ru',
    '',
    123,
    []
];

(new \App\App())
    ->setEmails($emailsList)
    ->run();