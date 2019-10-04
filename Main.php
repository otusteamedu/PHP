<?php

declare(strict_types=1);

include_once("src/EmailVerification.php");

$emailList = [];
$emailList[] = "ivanina@tutu.ru";
$emailList[] = "23";
$emailList[] = "23@dg.ua";
$emailList[] = "@com.ua";
$emailList[] = "hh@.ru";

foreach ($emailList as $email) {
    if ((new EmailVerification)->checkEmail($email)) {
        echo "$email - валидный email\n";
    } else
    {
        echo "$email - невалидный email\n";
    }
}

