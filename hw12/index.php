<?php

require '/Users/khutornaya/otus/PHP/hw12/src/Validation/Validator.php';

use Validation\Validator;

$file = 'EmailsList';
$vFileEmails = new Validator($file);
echo "\n\nValid Emails:\n";
print_r($vFileEmails->validEmails);
echo "\n\nBad emails:\n";
print_r($vFileEmails->badEmails);