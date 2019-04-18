<?php

require_once 'vendor/autoload.php';

use \timga\emailValidator\EmailValidator;

$email = 'tgavrytenko@mail.ru';
$emailValidator = new EmailValidator();
$emailValidator->setEmail($email);
if ($emailValidator->validate()) {
    print_r($emailValidator->getMxRecords());
} else {
    print_r($emailValidator->getErrors());
}
