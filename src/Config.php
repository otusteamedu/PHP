<?php
declare(strict_types = 1);

namespace Alex\Youtubestat;


class Config
{
    public function __construct()
    {
        $config_file = 'config.json';

        if (!is_file($config_file)) {
            throw new \Exception('Config file '. basename($config_file) . ' not found in root directory.');
        }

        $fp = fopen($config_file, 'rb');
        if (!$fp) {
            throw new \Exception('Can\'t open config file '. basename($config_file) . '.');
        }

        $config_str = '';

        while (!feof($fp)) {
            $config_str .= fgets($fp, 1024);
        }

        fclose($fp);

        if (trim($config_str) === '') {
            throw new \Exception('Config file '. basename($config_file) . ' is empty.');
        }

        $config_data = json_decode($config_str);
        if (empty($config_data)) {
            throw new \Exception('Config data is empty.');
        }

        foreach ($config_data as $k => $v) {
            $this->{$k} = $v;
        }

    }
}