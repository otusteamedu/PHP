<?php

require_once __DIR__ . '/vendor/autoload.php';

$input = [
    'email1@gmail.com',
    'email2@mail.ru',
    'email3@snelnl.com',
    'email4sd@ladocas7464367347438383484dasdalaasdasdahost.com',
];

$controller = new \Marchenko\Controller($input);
$controller->process();
