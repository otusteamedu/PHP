<?php


namespace Helpers;


class Session
{
    public static function setCount(): void
    {
        if (!isset($_SESSION['count'])) {
            $_SESSION['count'] = 0;
        } else {
            $_SESSION['count']++;
        }
    }
}