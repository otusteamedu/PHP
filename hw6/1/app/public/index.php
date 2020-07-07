<?php

use EmailVerifier\EmailVerifier;
use EmailVerifier\ErrorPrinter;
use EmailVerifier\Verifier\MX;
use EmailVerifier\Verifier\Spell;

require_once(__DIR__ . '/../vendor/autoload.php');

$emails = [
    'test@mail.ru',
    'test@yandex.ru',
    'test@gmail.com',
    'test@test.zzz',
    'test@testru',
    'testtestru',
];

$emailVerifier = (new EmailVerifier)
    ->addVerifier(new Spell)
    ->addVerifier(new MX);

foreach($emails as $email) {
    echo $email . '<br>' . PHP_EOL;
    $errors = $emailVerifier->run($email);
    if (!empty($errors)) {
        ErrorPrinter::print($errors);
    } else {
        echo 'Ok<br>' . PHP_EOL;
    }
    echo '-----'  . '<br>' . PHP_EOL;
}


