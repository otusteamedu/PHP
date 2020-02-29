<?php

require_once 'vendor/autoload.php';

$checker = new \Astrviktor\Tools\Checker\Checker();


$emailList = ['.123456@i.ru ', '123456@gmail.com', 'asasas#mail.ru', 'buba@buba.ru', 'MAIL@MAIL.RU'];

$emailListStatus = $checker->checkEmailList($emailList);

print_r("Email List Status: " . PHP_EOL);
print_r($emailListStatus);
