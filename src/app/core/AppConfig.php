<?php

namespace Core;

class AppConfig
{
    public $validation;

    public function __construct(?string $iniFilePath = null)
    {
        if (file_exists($iniFilePath) && ($conf = parse_ini_file($iniFilePath, true))) {
            $this->validation = $conf["validation"] ?? [];
        }
    }
}