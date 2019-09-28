<?php

use EmailChecker\EmailChecker;
use EmailChecker\Exceptions\EmailIsNotExists;
use EmailChecker\Exceptions\EmailSyntaxIsNotValid;
use EmailChecker\Validator\MxValidator;
use EmailChecker\Validator\SyntaxValidator;

require_once __DIR__ . '/vendor/autoload.php';

$arEmails = ['pankovalxndr@gmail.com', 'pankovalxndrgmail.com', 'pankovalxndr@blablabla.com'];

foreach ($arEmails as $email) {
    try {
        $emailVerifier = (new EmailChecker())
            ->addValidator(new SyntaxValidator())
            ->addValidator(new MxValidator());

        if ($emailVerifier->isCorrect($email)) {
            echo "{$email} - успешно прошел проверку";
        }
    } catch (EmailIsNotExists $exception) {
        echo $exception->getMessage();
    } catch (EmailSyntaxIsNotValid $exception) {
        echo $exception->getMessage();
    }
    echo PHP_EOL;
}