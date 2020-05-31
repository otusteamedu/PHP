<?php
namespace hw6;

use hw6\VerifyEmail;

class App
{
    public function run()
    {
        header('Content-Type: text/plain; charset=utf-8');
        echo 'IP = ', $_SERVER['SERVER_ADDR'], PHP_EOL;

        $email = filter_input(INPUT_POST, 'email');
        $verify = new VerifyEmail();
        $verify->check($email);
    }
}