<?php

use Validators\email\EmailValidator;

require_once __DIR__ . '/vendor/autoload.php';

echo "<pre>";

$validator = new EmailValidator();

// Example validate single
$check_email = 'new-test@ts.erds';
var_dump([$check_email => $validator->validate($check_email)]);

// Example validate array
$arr_res = $validator->validateMultiple([
    'sdfsdf@sdsdfg.ri',
    'vxor@pvn.db',
    'portele@gmail.com',
    'test@test.com',
    'bartak@asdfasdf.com',
    'galbra@verizon.net',
    'frostman@msn.com',
    'amichalo@comcast.net',
    'isotopian@comcast.net',
    'neuffer@outlook.com',
    'bigmauler@mac.com',
    'aglassis@comcast.net',
    'chrwin@me.com',
    'sartak@sbcglobal.net',
]);
var_dump($arr_res);

echo "</pre>";


exit;