<?php

namespace App;

class Config
{
    protected $path = __DIR__ . '/../conf.ini';
    protected $data = [];

    public function __construct()
    {
        $this->fillData();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    protected function fillData()
    {
        $conf = parse_ini_file($this->path);
        foreach ($conf as $item => $value) {
            $this->data['db'][$item] = $value;
        }
    }
}