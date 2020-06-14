<?php


namespace App\Settings;


class Config
{
    const DIR_CFG = __DIR__ . "/../config/";

    protected $params;

    public function __construct($configFileName)
    {
        $fullPath = self::DIR_CFG . $configFileName;
        if (file_exists($fullPath))
            $this->params = require_once $fullPath;
    }

    public function __get($name)
    {
        return $this->params[$name] ?? '';
    }

}