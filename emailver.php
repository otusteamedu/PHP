#!/usr/bin/php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use \Email\EmailVerification;

$email = 'test@test.ru';

$emailObj = new EmailVerification();

if ($emailObj::checkEmail($email)) {

    if ($emailObj::checkMX($email)) 
	echo 'MX zone for this Email found.'.PHP_EOL; 
    else 
	echo 'MX zone for this Email not found.'.PHP_EOL;
	
} else 
    echo 'Bad Email format'.PHP_EOL;

