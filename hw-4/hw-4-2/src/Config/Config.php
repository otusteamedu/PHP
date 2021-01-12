<?php


namespace Config;


class Config
{
    public static function getConfig()
    {
        return parse_ini_file('../config.ini');
    }
}