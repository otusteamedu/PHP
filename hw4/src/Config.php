<?php

namespace Deadly117;

use Exception;

class Config
{
    private $data;

    public function __construct($filename)
    {
        if (!is_readable($filename)) {
            throw new Exception("config file [{$filename}] not found");
        }

        $temp = parse_ini_file($filename);
        if ($temp === false) {
            throw new Exception('parse ini failed');
        }

        $this->data = $temp;
    }

    public function getValue($name)
    {
        $val = null;

        if (isset($this->data[$name])) {
            $val = $this->data[$name];
        } else {
            throw new Exception("config [{$name}] not found");
        }

        return $val;
    }
}