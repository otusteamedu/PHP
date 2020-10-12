<?php

namespace App;

class App
{

    public function run()
    {
        $email_validator = new \Validator\EmailValidator\EmailValidator([new \Validator\EmailValidator\EmailRegexpValidator(), new \Validator\EmailValidator\EmailRegexpValidator()]);

        $emails = Util::getEmails();
        if (empty($emails)) {
            throw new \Exception('Не введены email на проверку.');
        }
        $email_validator->setEmails($emails);

        $validator = new \Validator\Validator($email_validator);
        Util::dump($validator->validate());
    }

}