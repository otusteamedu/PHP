<?php

require_once __DIR__ . '/vendor/autoload.php';

$value = $_POST['string'];
$validator = new \App\Services\Validator($value);

$validator->notEmpty();
$validator->length(48);
$validator->addRegexp("<[a-z][=][()]+>");
$validator->countingSymbols('(', 20);
$validator->countingSymbols(')', 21);

$validationErrors = $validator->getErrors();

if ($validationErrors) {
    http_response_code(400);
    echo 'Ошибка - ваш запрос не прошел валидацию' . PHP_EOL . PHP_EOL;
    foreach ($validationErrors as $error) {
        echo $error . PHP_EOL;
    }
} else {
    http_response_code(200);
    echo 'Валидация прошла успешно.';
}