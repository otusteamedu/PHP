<?php

use App\EmailValidator;
use App\EmailValidatorException;
use App\EmailValidators\BlockedHostValidator;
use App\EmailValidators\DNSMXRecordValidator;
use App\EmailValidators\EmailDNSmxValidator;
use App\EmailValidators\EmailPhpFilterValidator;
use App\EmailValidators\PhpFilterValidator;

require_once 'vendor/autoload.php';

$emailsToCheck = [
    'email@example.com',
    'firstname.lastname@example.com',
    'email@subdomain.example.com',
    'firstname+lastname@example.com',
    'email@123.123.123.123',
    'email@[123.123.123.123]',
    '"email"@example.com',
    '1234567890@example.com',
    'email@example-one.com',
    '_______@example.com',
    'email@example.name',
    'email@example.museum',
    'email@example.co.jp',
    'firstname-lastname@example.com',
    '@sdf',
    'asdasd@yandex.ru',
];

$phpFilterValidator   = new PhpFilterValidator();
$dnsMxRecordValidator = new DNSMXRecordValidator();
$blockedHostValidator = new BlockedHostValidator(['yandex.ru']);

$phpFilterValidator
    ->setNext($dnsMxRecordValidator)
    ->setNext($blockedHostValidator);

$validationResult = [];
foreach ($emailsToCheck as $email) {
    try {
        $phpFilterValidator->validate($email);
        $validationResult[$email] = 'Ok';
    } catch (EmailValidatorException $exception) {
        $validationResult[$email] = $exception->getMessage();
    } catch (Throwable $exception) {
        $validationResult[$email] = 'Неожиданная ошибка: ' . $exception->getMessage();
    }
}

print_r($validationResult);