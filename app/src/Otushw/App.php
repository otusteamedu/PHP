<?php

namespace Otushw;

use Otushw\Config;

/**
 * Class App
 *
 * @package Otushw
 */
class App
{

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $app = AppFactory::create();
        $app->execute();
    }

    private function loadConfig(): void
    {
        $config = new Config(__DIR__ . '/../config.yaml');
        $config->load();
    }

}