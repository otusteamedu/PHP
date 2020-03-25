<?php

use MailChecker\MailChecker;

require __DIR__.'/../vendor/autoload.php';



echo 'Server IP: ' . $_SERVER['SERVER_ADDR'];
echo '<br>';

if (!empty($email = $_GET['email'])) {
    $app = new MailChecker();
    echo $app->check($_GET['email']) ? "Email $email valid" : "Email $email is not valid";
} else {
    echo 'Pass variable "email"';
}