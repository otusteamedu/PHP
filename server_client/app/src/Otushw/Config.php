<?php

namespace Otushw;

use Exception;

class Config
{
    protected $path;

    const PATH_CONFIG = '../config.ini';

    public function readAll()
    {
        return parse_ini_file(self::PATH_CONFIG);
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