<?php

require 'vendor/autoload.php';

use App\EmailService;

$emails = [
    'f.pronin@fin.media',
    'feodor.pronin@gmail.com',
    'da93jda[3@2d3a33@mail.ru',
    'da93jda[3@2d3a33/d.dd',
    'sdsdsda',
];

foreach ($emails as $email) {
    echo $email . ' - ';
    echo EmailService::validateEmail($email) ? 'ok' : 'not valid';
    echo '<br />';
}