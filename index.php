<?php
require 'vendor/autoload.php';

use Eantonov\EmailValidator;

$invalidEmail = 'test12345qwerty@test.ru';
$validEmail = 'antonov.evgenij1987@yandex.ru';
$emailValidator = new EmailValidator;
echo ($emailValidator->validate($invalidEmail)) ? 'valid' . PHP_EOL : 'invalid' . PHP_EOL;
echo ($emailValidator->validate($validEmail)) ? 'valid' . PHP_EOL : 'invalid' . PHP_EOL;

