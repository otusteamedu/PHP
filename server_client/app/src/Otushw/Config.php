<?php

namespace Otushw;

use Exception;

class Config
{
    protected $path;

    public function __construct($path)
    {
        if (!file_exists($path)) {
            throw new Exception('File "config.ini" does not exist');
        }
        $this->path = $path;
    }

    public function readAll()
    {
        return parse_ini_file($this->path);
    }

    public function readParam($nameParam)
    {
        $allParams = $this->readAll();
        if (!isset($allParams[$nameParam])) {
            throw new Exception('Parameter: "$nameParam" does not exist in file config.ini');
        }

        return $allParams[$nameParam];
    }
}