<?php


namespace App;


class Util
{
    public static function pre($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }
}