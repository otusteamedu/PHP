<?php
namespace hw6;

use hw6\VerifyEmail;

class App
{
    public function run()
    {
        $result = [];
        $result[] = "IP = {$_SERVER['SERVER_ADDR']}";

        $email = filter_input(INPUT_POST, 'email');
        $verify = new VerifyEmail();
        $temp = $verify->check($email);
        $result = array_merge($result, $temp);

        return implode(PHP_EOL, $result);
    }
}