<?php

require $_SERVER['DOCUMENT_ROOT'] . '/src/Otus/Validator/Emails.php';

use Otus\Validator\Emails;

$emails = [
    'hahnjeremy@mail.ru',
    'julia17@baddomain.bad',
    'mary79@gmail.com',
    'waynenavarro@larson-sanchez.com',
    'alvaradohoward@yandex.ru',
    'fsh286f3^%&^@gds',
];
$file = $_SERVER['DOCUMENT_ROOT'] . '/emails';

$vArrayEmails = new Emails($emails);
$vFileEmails = new Emails($file);

echo '<pre>';

echo "Valid Emails from array:\n";
print_r($vArrayEmails->getValidEmails());

echo "\n\nBad emails:\n";
print_r($vArrayEmails->badEmails);

echo "\n\nValid Emails from file:\n";
print_r($vFileEmails->getValidEmails());

echo "\n\nBad emails:\n";
print_r($vFileEmails->badEmails);

echo '<pre>';
