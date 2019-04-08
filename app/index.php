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

$emailService = new EmailService();

foreach ($emails as $email) {
    echo $email . ' - ' . ($emailService->validateEmail($email) ? 'ok' : 'not valid') . PHP_EOL;
}