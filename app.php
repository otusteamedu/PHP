<?php

use App\App;
use App\Validators\BracketValidator;
use App\Validators\EmailValidator;

require_once __DIR__ . '/vendor/autoload.php';
try {
    (new App())->run();
    App::validPost([
        'string'    => BracketValidator::class,
        //Example: test@mail.ru is valid, but test@gmail.ru is invalid
        'email'     => (new EmailValidator())
            ->setDeniedRootDomains(['gmail'])
            ->setAllowedRootDomains(['mail']),
        'email_two' => EmailValidator::class
    ]);
} catch (Throwable $e) {

}
