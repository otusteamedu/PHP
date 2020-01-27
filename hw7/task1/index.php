<?php
require "vendor/autoload.php";

use Ushakov\EmailValidator\EmailValidator;

$emails = [
    "ilya@ushakov.me",
    "ilya_ushakov@yandex.ru",
    "ilya ushakov@gmail.com",
    "ilya-ushakovgmail.com",
    "ilya@gmail. com",
    "тест@yandex.ru",
    "aa * bbb",
    "helli@ttttttttttttttttttttt.ru", // Невалидный домен
];

foreach ($emails as $email) {
    echo "$email is " . (EmailValidator::validate($email) ? "ok" : "not ok") . PHP_EOL;
}
