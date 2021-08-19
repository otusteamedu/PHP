<?php

namespace app\Http\SystemInformation;


use app\Http\Controllers\Auth\Auth;


class SysInfo
{
    public static function showInfo(): void
    {
        echo "Пользователь:", Auth::userName(), " Зашел на сайт ", Auth::getFirstTimeVisit(), PHP_EOL;
        echo "Адрес веб-сервера: ", $_SERVER['SERVER_ADDR'], PHP_EOL;
        echo 'Адрес ноды FPM: ' . getHostByName(php_uname('n')), PHP_EOL;
    }

}