<?php

namespace Ozycast\App;

use Ozycast\App\Email;

class App
{
    public function run()
    {
        $emails = [
            "ozy@nxt.ru",
            "ozycast@gmail.com",
            "ozycast@gmail.ru",
            "ozycast@gmail",
            "ozycastgmail",
            "ozycastgmail@",
            "ozycastgmail@.dd",
            "ozycastgmail@ddd.dd.com",
            "@.dd",
        ];

        foreach ($emails as $email) {
            echo "\n\rПроверка " . $email . "....................";
            $emailCheck = new Email($email);

            if (!$emailCheck->check()) {
                echo "Ошибка (" . $emailCheck->getError() . ")";
                continue;
            }

            echo "OK";
        }

        return;
    }
}
