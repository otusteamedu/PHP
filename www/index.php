<?php

header("Content-Type: application/json; charset=UTF-8");

include_once 'vendor/autoload.php';

$ans = ['server' => gethostname()];

$email_array = json_decode($_POST['email']);
if (empty($email_array))
    array_push($ans, ['answer' => 'empty']);
else
    foreach ($email_array as $email) {
        $chk = ['email' => $email,
            'verify' =>
                Verify::verifyEmail($email)];
        array_push($ans, $chk);
    }

echo json_encode($ans);