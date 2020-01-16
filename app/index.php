<?php
require __DIR__ . '/vendor/autoload.php';
$emails = '';
$arEmails = [];

if ($_POST['emails']) {
    $emails = htmlspecialchars($_POST['emails']);
    $arEmails = explode(',', $emails);
    $emailValidator = new \Azatnizam\Email\Validator();

    foreach ($arEmails as $email) {
        if ( $emailValidator->validate($email) ) {
            print($email . " is valid\n");
        } else {
            print($email . " is invalid\n");
        }
    }

} else {
    print('Please enter email');
}

