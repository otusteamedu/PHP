<?php
require 'vendor/autoload.php';

use Otus\Validator\Emails;

if ($email = $_GET['email']) {
    
    $vEmails = new Emails([$email]);
    
    if ($vEmails->getValidEmails()) {
        die('Email valid!');
    } else {
        die('Email not valid!');
    }
}

die('Enter "email" field!');