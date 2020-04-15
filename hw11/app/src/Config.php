<?php


namespace HW;


class Config
{
    const DIR_CFG = __DIR__ . "/../cfg/";

    public static function youtube()
    {
        return self::get('youtube');
    }

    public static function mongo()
    {
        return self::get('mongo');
    }

    public static function redis()
    {
        return self::get('redis');
    }

    private static function get($cfgName)
    {
        return require_once(self::DIR_CFG . "$cfgName.php");
    }

}