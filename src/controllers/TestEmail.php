<?php


namespace controllers;


use Services\Email\allowedEmails;
use Services\Email\emailServicesLib;

class TestEmail
{
    public function run():void
    {
        echo "<pre>";
        echo "Адрес вебсервера: ", $_SERVER['SERVER_ADDR'], PHP_EOL;
        echo 'Адрес ноды FPM: ' . getHostByName(php_uname('n')), PHP_EOL;
        $this->emailLib = new emailServicesLib(allowedEmails::getList());
        print_r($this->emailLib->getFormattedEmailList());
        foreach (allowedEmails::getList() as $mail) {
            $this->checkEmail($mail);
        }
    }

    private function checkEmail($mail):void
    {
        echo "Почтовый ящик $mail -> ";
        try {
            echo $this->emailLib->isValidEmail($mail) ? "Валидный\n" : "Не Валидный\n";
        } catch (\Exception $exception) {
            echo "Не Валидный, т.к. ", $exception->getMessage(), PHP_EOL;
        }
    }

}