<?php

namespace Core;

class AppConfig
{
    public $textRules;

    public function __construct(?string $iniFilePath = null)
    {
        if (file_exists($iniFilePath) && ($conf = parse_ini_file($iniFilePath, true))) {
            $this->textRules = $conf["textRules"] ?? [];
        }
    }
}