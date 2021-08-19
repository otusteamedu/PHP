<?php

namespace app\Http\Controllers\Auth;

class Auth
{
    public static function userName(): string
    {
        return "TestUser";
    }

    public static function getFirstTimeVisit(): string
    {
        if (!isset($_SESSION['first_visit_time'])) {
            $_SESSION['first_visit_time'] = date("d-m-Y,H:i:s");
        }
        return $_SESSION['first_visit_time'];
    }

}