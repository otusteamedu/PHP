<?php

namespace Src;


class App
{
    public function run(): void
    {
        $fileReader = new FileReader($_ENV['EMAILS_FILE_PATH']);
        $emails = $fileReader->read();

        foreach($emails as $email) {
            echo "checking {$email}: ";
            $emailValidator = new EmailValidator($email);
            echo ($emailValidator->isEmailValid() ? 'Email is valid' : 'Email is not valid') . PHP_EOL;
        }
    }
}