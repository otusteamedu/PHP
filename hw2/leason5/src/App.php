<?php

use validator\CEmailValidator;

class App
{
    public function run()
    {
        $this->testEmail();
    }


    public function testEmail()
    {
        $emails = [
            'user@server.com',
            'guest@company.com',
            'info@yandex.com',
            'root@sale.com',
            'info@otus.ru',
            'admin@express42.ru',
        ];

        $validator = new CEmailValidator();
        foreach ($emails as $email) {
            $valid = $validator->validate($email);
            $msg   = sprintf('Email %s is %s', $email, ($valid) ? 'valid' : 'not valid');
            echo "$msg \n";
        }
    }
}
