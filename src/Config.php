<?php

namespace Tirei01\Hw4;

class Config
{
    protected $arConf;
    protected $key;

    public function __construct($section = 'server')
    {
        $this->key = $section;
        $this->arConf = parse_ini_file(__DIR__ . '/../config/config.ini', true);
    }

    public function get($param)
    {
        if (array_key_exists($this->key, $this->arConf)) {
            $section = $this->arConf[$this->key];
            if (array_key_exists($param, $section)) {
                return $section[$param];
            }
        }
        return null;
    }
}