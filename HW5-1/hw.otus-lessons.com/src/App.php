<?php

namespace App;

class App
{

    public function run()
    {
        $email_validator = new \Validator\EmailValidator\EmailValidator();

        $emails = [
            '1',
            'asd12',
            'asd@asd',
            'ter123@',
            'ter123@ter.ru',
            'ter123@tsad213.i32184/ ds',
            'woplek@yandex.ru'
        ];

        $email_validator->setEmails($emails);

        $validator = new \Validator\Validator($email_validator);
        Util::dump($validator->validate());
    }

}