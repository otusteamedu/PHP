<?php
require_once('vendor/autoload.php');

use EvilWolf\EmailValidator;

$lineBreak = '<br>';
if (php_sapi_name() === 'cli') {
   $lineBreak = PHP_EOL;
}

$emails = [
    'valid@mail.ru',
    'invalid@domain..ru',
    'v.a.l.i.d@mail.ru',
];

foreach ($emails as $email) {
    $validator = new EvilWolf\EmailValidator($email);
    echo $email . ' ' . ($validator->isValid() ? 'valid' : 'invalid') . $lineBreak;
}
