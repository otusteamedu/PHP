<?php

require '../vendor/autoload.php';

use Otushw\VerificationEmail;

try {
    $emails = [
        'aaaa',
        'babbab@asdad.ds',
        'asb@example.com'
    ];

    $app = new VerificationEmail();
    $app->validation($emails);
} catch (Exception $e) {

}