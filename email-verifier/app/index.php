<?php

use App\EmailValidator;
use App\EmailValidators\EmailDNSmxValidator;
use App\EmailValidators\EmailPhpFilterValidator;

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
];

$emailValidator = (new EmailValidator())
    ->addValidator(new EmailPhpFilterValidator())
    ->addValidator(new EmailDNSmxValidator());

$emailValidator->runBatch($emailsToCheck);
$result = $emailValidator->getResults();

exit;
