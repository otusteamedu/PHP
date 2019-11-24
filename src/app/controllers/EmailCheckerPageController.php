<?php

namespace Controllers;

use Core\AppController;

class EmailCheckerPageController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function getCorrectEmailsListStr()
    {
        return implode(",", [
            "studio-rs@yandex.ru",
            "studio-rs@mail.ru",
            "79824754868@ya.ru",
            "richie.seagull@gmail.com"
        ]);
    }

    public static function getIncorrectEmailsListStr()
    {
        return implode(",", [
            "studio-rs@yandex.ru",
            "study@com",
            "studio-rs@mail.ru",
            "79824754868@ya.ru",
            "-678@mail@mail.ru",
            "_george-har@dot.net",
            "richie.seagull@gmail.com"
        ]);
    }

    public static function getIncorrectMxEmailsListStr()
    {
        return implode(",", [
            "studio-rs@yandex.ru",
            "studio-rs@yambex.ru",
            "studio-rs@mai1.ru",
            "79824754868@уа.ru",
            "-678@mail@mail.кu",
            "george-har@yahоо.nеt"
        ]);
    }
}