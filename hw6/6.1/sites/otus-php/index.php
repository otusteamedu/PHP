<?php

declare(strict_types=1);

use App\Validators\EmailValidator;
use App\Configs\Config;

require_once('src/EmailValidator.php');
require_once('src/Config.php');

$config = new Config('dev');

$emails = [
    'test@email.com',
    'wrongemail.com',
    'wrong@com2',
    'rus@емаил.рф',
    'вася@емаил.рф',
    'newrus@емаил.com',
    'test@yandex.ru',
    'тест@mail.ru',
    'тест@почта.рус',
];

$validatorResult = new EmailValidator($emails);

    echo 'Следующие email адреса прошли валидацию:<br><br>';
    foreach ($validatorResult as $email) {
        foreach ($email as $item) {
            echo "{$item} <br>";
        }
    }

