<?php

namespace App;

class Identity
{

    private static $objects = [];


    static function addRecord($obj, $id)
    {
        self::$objects[$id] = $obj;
    }

    static function getRecord($id)
    {
        return self::$objects[$id];
    }
}