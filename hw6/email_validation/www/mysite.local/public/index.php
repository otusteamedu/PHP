<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\Validation\Usage\EmailValidation;

$emailsList = [
    'test@test.ru',
    '123@yandex.ru',
    '',
    123,
    []
];

$usage = new EmailValidation();

foreach ($emailsList as $email) {
    echo sprintf('Проверяем: "%s"<br />', $email);
    try {
        $usage->exec($email);
        echo 'Корректно<br />';
    } catch (\RuntimeException $ex) {
        echo sprintf('Ошибка при валидации: %s<br />', $ex->getMessage());
    } catch (\Exception $t) {
        echo sprintf(
            'Непредвиденная ошибка: %s<br />',
            $t->getMessage()
        );
        echo $t->getTraceAsString().'<br />';
    }
    echo '<br />';
}