<?php
/**
 * Simple application
 *
 * @author Petr Ivanov (petr.yrs@gmail.com)
 */

use models\EmailModel;

class App
{
    public function run()
    {
        $this->testEmail();
    }


    public function testEmail()
    {
        $emails = [
            'info@otus.ru',
            'petr.yrs@gmail.com',
            'guest@company.com',
            'info@yandex.com',
            'root@sale.com',
            'user@server.com',
            'admin@express42.ru',
        ];

        $model = new EmailModel();
        foreach ($emails as $email) {
            $model->email = $email;
            $model->clearError();
            $valid = $model->validate('email');
            echo sprintf("Email %s is %s \n", $email, ($valid) ? 'valid' : 'not valid');
            if ($model->hasError()) {
                echo 'Error: '.print_r($model->getLastError(), true);
            }
        }
    }
}
