<?php

use EmailVerifier\Checker\BasicChecker;
use EmailVerifier\EmailVerifier;
use EmailVerifier\Exceptions\EmailIsNotExists;
use EmailVerifier\Exceptions\EmailSyntaxIsNotValid;
use EmailVerifier\Validator\MxValidator;
use EmailVerifier\Validator\SyntaxValidator;

require_once __DIR__ . '/../vendor/autoload.php';

$emailsToCheck = ['admin@gmailwhichisnotexists.com', 'invalidemail.com', 'admin@gmail.com'];
foreach ($emailsToCheck as $email) {
    try {
        $emailVerifier = (new EmailVerifier())
            ->addValidator(new SyntaxValidator())
            ->addValidator(new MxValidator());

        if($emailVerifier->isCorrect($email)) {
            echo "Email {$email} is valid";
        }
    } catch (EmailIsNotExists $exception) {
        echo "Email {$email} is not exists";
    } catch (EmailSyntaxIsNotValid $exception) {
        echo "Email syntax {$email} is not valid";
    }
    echo PHP_EOL;
}