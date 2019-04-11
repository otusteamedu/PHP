<?php

use nvggit\EmailValidator;

require "./vendor/autoload.php";

$validator = new EmailValidator();
$validator->validate($argv[1]);
echo $validator->getMessage() . "\n";
exit;