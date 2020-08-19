<?php


namespace Common;

use Models\Users\User;

class Cookie
{
    /**
     * Функция установки Куки авторизованному пользователю
     * @param User $user|null
     * @return void
     */
    public static function setLoginCookie(?User $user): void
    {
        if ($user) {
            setcookie("id", $user->getId(), time()+60*60*24*30);
            setcookie("hash", $user->getHash(), time()+60*60*24*30);
        }
    }

    /**
     * Функция удаления Куки пользователю для logout
     * @param User $user|null
     * @return void
     */
    public static function removeLoginCookie(?User $user): void
    {
        if ($user) {
            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/");
            unset($_COOKIE['id']);
            unset($_COOKIE['hash']);
        }
    }
}