<?php
require_once "vendor/autoload.php";

use Jekys\Email;

$emails = [
    'test@test',
    'test@gmail',
    'foo@bar.com',
    'test@gmail.com',
    'test@ya',
    'test@ya.ru',
    'test@jekys.ru'
];

foreach ($emails as $email) {
    print $email." - ".(Email::check($email) ? 'valid' : 'invalid').PHP_EOL;
}
