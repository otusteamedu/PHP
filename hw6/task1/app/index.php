<?php

require_once __DIR__ . '/vendor/autoload.php';

$value = $_POST['email'];
$validator = new \App\Services\Validator($value);

$validator->notEmpty();
$validator->addRegexp("<\S{1,}@\S{2,}\.\S{2,}>");
$validator->validateMx();
$validator->validateEmail();

$validationErrors = $validator->getErrors();

if ($validationErrors) {
    http_response_code(400);
    echo 'Ошибка - ваша почта не прошла валидацию' . PHP_EOL . PHP_EOL;
    foreach ($validationErrors as $error) {
        echo $error . PHP_EOL;
    }
} else {
    http_response_code(200);
    echo 'Валидация прошла успешно.';
}