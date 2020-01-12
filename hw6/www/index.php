<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Validator\EmailValidator;

$emails = ['correct@gmail.com',
    '@gmail,com',
    'correct@yandex.ru',
    'incorrect@incorrect.incorrect',
    'incorrect',
    'correct@mail.ru'];

$validEmails = ['correct@gmail.com',
    'correct@yandex.ru',
    'correct@mail.ru'];

$validator = new EmailValidator();

echo "Server IP : ". $_SERVER['SERVER_ADDR']."<br />";
echo '<h1>Валидация списка некорректных email</h1>';
echo '<div>'.$validator->isValid($emails).'</div>';
echo '<h1>Валидация корректного списка email</h1>';
echo '<div>'.$validator->isValid($validEmails).'</div>';
