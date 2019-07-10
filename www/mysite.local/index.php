<?php
require 'vendor/autoload.php';

use Otus\Validator\Emails;

if ($email = trim($_GET['email'])) {
    try {
        $EmailValidator = new Emails();
        if ($EmailValidator->validate($email)) {
            echo 'Email valid!';
        }
    } catch (Exception $e) {
        echo 'Error: ',  $e->getMessage();
    }
}