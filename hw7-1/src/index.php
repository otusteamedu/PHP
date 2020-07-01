<?php

include_once 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

try {
    $mx = 'mx.yandex.ru';
    $email = 'result.99@mail.ru';

    $email_array = [
        'result.99@mail.ru',
        'finalfantasy.99@mail.ru',
        '23444'
    ];

    $validation_email = new \Services\ValidationService('email');

    echo ($validation_email->single($email))
        ? 'Валиден: ' . $email . "\n"
        : 'Не валиден: ' . $email . "\n";

    foreach ($validation_email->multi($email_array) AS $element) {
        echo ($element['valid'])
            ? 'Валиден: ' . $element['email'] . "\n"
            : 'Не валиден: ' . $element['email'] . "\n";
    }

    $validation_dns = new \Services\ValidationService('dns_mx');

    echo ($validation_dns->single($mx))
        ? 'Валиден: ' . $mx . "\n"
        : 'Не валиден: ' . $mx . "\n";


} catch (Exception $e) {
    echo 'Exception: ',  $e->getMessage(), "\n";
}


