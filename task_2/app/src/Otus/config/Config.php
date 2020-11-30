<?php

namespace Otus\config;

class Config
{
    public static function readConfig()
    {
        return yaml_parse_file('../config/ini.yaml');
    }

}