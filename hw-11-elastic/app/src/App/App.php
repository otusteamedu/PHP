<?php

namespace App;

use Config\Config;

/**
 * Class App
 *
 * @package App
 */
class App
{
    private Config $config;

    public function __construct ()
    {
        $this->config = new Config();
    }

    /**
     * run the app
     */
    public function run (): void
    {

    }
}